(function(mod) {
  if (typeof exports == "object" && typeof module == "object") 
    mod(require("../../lib/codemirror"));
  else if (typeof define == "function" && define.amd) 
    define(["../../lib/codemirror"], mod);
  else 
    mod(CodeMirror);
})(function(CodeMirror) {
"use strict";
CodeMirror.defineMode("tiddlywiki", function () {
  var textwords = {};
  var keywords = function () {
    function kw(type) {
      return { type: type, style: "macro"};
    }
    return {
      "allTags": kw('allTags'), "closeAll": kw('closeAll'), "list": kw('list'),
      "newJournal": kw('newJournal'), "newTiddler": kw('newTiddler'),
      "permaview": kw('permaview'), "saveChanges": kw('saveChanges'),
      "search": kw('search'), "slider": kw('slider'),   "tabs": kw('tabs'),
      "tag": kw('tag'), "tagging": kw('tagging'),       "tags": kw('tags'),
      "tiddler": kw('tiddler'), "timeline": kw('timeline'),
      "today": kw('today'), "version": kw('version'),   "option": kw('option'),
      "with": kw('with'),
      "filter": kw('filter')
    };
  }();
  var isSpaceName = /[\w_\-]/i,
  reHR = /^\-\-\-\-+$/,                                 
  reWikiCommentStart = /^\/\*\*\*$/,            
  reWikiCommentStop = /^\*\*\*\/$/,             
  reBlockQuote = /^<<<$/,
  reJsCodeStart = /^\/\/\{\{\{$/,                       
  reJsCodeStop = /^\/\/\}\}\}$/,                        
  reXmlCodeStart = /^<!--\{\{\{-->$/,           
  reXmlCodeStop = /^<!--\}\}\}-->$/,            
  reCodeBlockStart = /^\{\{\{$/,                        
  reCodeBlockStop = /^\}\}\}$/,                 
  reUntilCodeStop = /.*?\}\}\}/;
  function chain(stream, state, f) {
    state.tokenize = f;
    return f(stream, state);
  }
  var type, content;
  function ret(tp, style, cont) {
    type = tp;
    content = cont;
    return style;
  }
  function jsTokenBase(stream, state) {
    var sol = stream.sol(), ch;
    state.block = false;        
    ch = stream.peek();         
    if (sol && /[<\/\*{}\-]/.test(ch)) {
      if (stream.match(reCodeBlockStart)) {
        state.block = true;
        return chain(stream, state, twTokenCode);
      }
      if (stream.match(reBlockQuote)) {
        return ret('quote', 'quote');
      }
      if (stream.match(reWikiCommentStart) || stream.match(reWikiCommentStop)) {
        return ret('code', 'comment');
      }
      if (stream.match(reJsCodeStart) || stream.match(reJsCodeStop) || stream.match(reXmlCodeStart) || stream.match(reXmlCodeStop)) {
        return ret('code', 'comment');
      }
      if (stream.match(reHR)) {
        return ret('hr', 'hr');
      }
    } 
    ch = stream.next();
    if (sol && /[\/\*!#;:>|]/.test(ch)) {
      if (ch == "!") { 
        stream.skipToEnd();
        return ret("header", "header");
      }
      if (ch == "*") { 
        stream.eatWhile('*');
        return ret("list", "comment");
      }
      if (ch == "#") { 
        stream.eatWhile('#');
        return ret("list", "comment");
      }
      if (ch == ";") { 
        stream.eatWhile(';');
        return ret("list", "comment");
      }
      if (ch == ":") { 
        stream.eatWhile(':');
        return ret("list", "comment");
      }
      if (ch == ">") { 
        stream.eatWhile(">");
        return ret("quote", "quote");
      }
      if (ch == '|') {
        return ret('table', 'header');
      }
    }
    if (ch == '{' && stream.match(/\{\{/)) {
      return chain(stream, state, twTokenCode);
    }
    if (/[hf]/i.test(ch)) {
      if (/[ti]/i.test(stream.peek()) && stream.match(/\b(ttps?|tp|ile):\/\/[\-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i)) {
        return ret("link", "link");
      }
    }
    if (ch == '"') {
      return ret('string', 'string');
    }
    if (ch == '~') {    
      return ret('text', 'brace');
    }
    if (/[\[\]]/.test(ch)) { 
      if (stream.peek() == ch) {
        stream.next();
        return ret('brace', 'brace');
      }
    }
    if (ch == "@") {    
      stream.eatWhile(isSpaceName);
      return ret("link", "link");
    }
    if (/\d/.test(ch)) {        
      stream.eatWhile(/\d/);
      return ret("number", "number");
    }
    if (ch == "/") { 
      if (stream.eat("%")) {
        return chain(stream, state, twTokenComment);
      }
      else if (stream.eat("/")) { 
        return chain(stream, state, twTokenEm);
      }
    }
    if (ch == "_") { 
      if (stream.eat("_")) {
        return chain(stream, state, twTokenUnderline);
      }
    }
    if (ch == "-") {
      if (stream.eat("-")) {
        if (stream.peek() != ' ')
          return chain(stream, state, twTokenStrike);
        if (stream.peek() == ' ')
          return ret('text', 'brace');
      }
    }
    if (ch == "'") { 
      if (stream.eat("'")) {
        return chain(stream, state, twTokenStrong);
      }
    }
    if (ch == "<") { 
      if (stream.eat("<")) {
        return chain(stream, state, twTokenMacro);
      }
    }
    else {
      return ret(ch);
    }
    stream.eatWhile(/[\w\$_]/);
    var word = stream.current(),
    known = textwords.propertyIsEnumerable(word) && textwords[word];
    return known ? ret(known.type, known.style, word) : ret("text", null, word);
  } 
  function twTokenComment(stream, state) {
    var maybeEnd = false,
    ch;
    while (ch = stream.next()) {
      if (ch == "/" && maybeEnd) {
        state.tokenize = jsTokenBase;
        break;
      }
      maybeEnd = (ch == "%");
    }
    return ret("comment", "comment");
  }
  function twTokenStrong(stream, state) {
    var maybeEnd = false,
    ch;
    while (ch = stream.next()) {
      if (ch == "'" && maybeEnd) {
        state.tokenize = jsTokenBase;
        break;
      }
      maybeEnd = (ch == "'");
    }
    return ret("text", "strong");
  }
  function twTokenCode(stream, state) {
    var ch, sb = state.block;
    if (sb && stream.current()) {
      return ret("code", "comment");
    }
    if (!sb && stream.match(reUntilCodeStop)) {
      state.tokenize = jsTokenBase;
      return ret("code", "comment");
    }
    if (sb && stream.sol() && stream.match(reCodeBlockStop)) {
      state.tokenize = jsTokenBase;
      return ret("code", "comment");
    }
    ch = stream.next();
    return (sb) ? ret("code", "comment") : ret("code", "comment");
  }
  function twTokenEm(stream, state) {
    var maybeEnd = false,
    ch;
    while (ch = stream.next()) {
      if (ch == "/" && maybeEnd) {
        state.tokenize = jsTokenBase;
        break;
      }
      maybeEnd = (ch == "/");
    }
    return ret("text", "em");
  }
  function twTokenUnderline(stream, state) {
    var maybeEnd = false,
    ch;
    while (ch = stream.next()) {
      if (ch == "_" && maybeEnd) {
        state.tokenize = jsTokenBase;
        break;
      }
      maybeEnd = (ch == "_");
    }
    return ret("text", "underlined");
  }
  function twTokenStrike(stream, state) {
    var maybeEnd = false, ch;
    while (ch = stream.next()) {
      if (ch == "-" && maybeEnd) {
        state.tokenize = jsTokenBase;
        break;
      }
      maybeEnd = (ch == "-");
    }
    return ret("text", "strikethrough");
  }
  function twTokenMacro(stream, state) {
    var ch, word, known;
    if (stream.current() == '<<') {
      return ret('brace', 'macro');
    }
    ch = stream.next();
    if (!ch) {
      state.tokenize = jsTokenBase;
      return ret(ch);
    }
    if (ch == ">") {
      if (stream.peek() == '>') {
        stream.next();
        state.tokenize = jsTokenBase;
        return ret("brace", "macro");
      }
    }
    stream.eatWhile(/[\w\$_]/);
    word = stream.current();
    known = keywords.propertyIsEnumerable(word) && keywords[word];
    if (known) {
      return ret(known.type, known.style, word);
    }
    else {
      return ret("macro", null, word);
    }
  }
  return {
    startState: function () {
      return {
        tokenize: jsTokenBase,
        indented: 0,
        level: 0
      };
    },
    token: function (stream, state) {
      if (stream.eatSpace()) return null;
      var style = state.tokenize(stream, state);
      return style;
    },
    electricChars: ""
  };
});
CodeMirror.defineMIME("text/x-tiddlywiki", "tiddlywiki");
});
