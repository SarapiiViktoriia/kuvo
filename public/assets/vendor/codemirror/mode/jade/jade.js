(function(mod) {
  if (typeof exports == "object" && typeof module == "object") 
    mod(require("../../lib/codemirror"));
  else if (typeof define == "function" && define.amd) 
    define(["../../lib/codemirror"], mod);
  else 
    mod(CodeMirror);
})(function(CodeMirror) {
"use strict";
CodeMirror.defineMode("jade", function () {
  var symbol_regex1 = /^(?:~|!|%|\^|\*|\+|=|\\|:|;|,|\/|\?|&|<|>|\|)/;
  var open_paren_regex = /^(\(|\[)/;
  var close_paren_regex = /^(\)|\])/;
  var keyword_regex1 = /^(if|else|return|var|function|include|doctype|each)/;
  var keyword_regex2 = /^(#|{|}|\.)/;
  var keyword_regex3 = /^(in)/;
  var html_regex1 = /^(html|head|title|meta|link|script|body|br|div|input|span|a|img)/;
  var html_regex2 = /^(h1|h2|h3|h4|h5|p|strong|em)/;
  return {
    startState: function () {
      return {
        inString: false,
        stringType: "",
        beforeTag: true,
        justMatchedKeyword: false,
        afterParen: false
      };
    },
    token: function (stream, state) {
      if (!state.inString && ((stream.peek() == '"') || (stream.peek() == "'"))) {
        state.stringType = stream.peek();
        stream.next(); 
        state.inString = true; 
      }
      if (state.inString) {
        if (stream.skipTo(state.stringType)) { 
          stream.next(); 
          state.inString = false; 
        } else {
          stream.skipToEnd(); 
        }
        state.justMatchedKeyword = false;
        return "string"; 
      } else if (stream.sol() && stream.eatSpace()) {
        if (stream.match(keyword_regex1)) {
          state.justMatchedKeyword = true;
          stream.eatSpace();
          return "keyword";
        }
        if (stream.match(html_regex1) || stream.match(html_regex2)) {
          state.justMatchedKeyword = true;
          return "variable";
        }
      } else if (stream.sol() && stream.match(keyword_regex1)) {
        state.justMatchedKeyword = true;
        stream.eatSpace();
        return "keyword";
      } else if (stream.sol() && (stream.match(html_regex1) || stream.match(html_regex2))) {
        state.justMatchedKeyword = true;
        return "variable";
      } else if (stream.eatSpace()) {
        state.justMatchedKeyword = false;
        if (stream.match(keyword_regex3) && stream.eatSpace()) {
          state.justMatchedKeyword = true;
          return "keyword";
        }
      } else if (stream.match(symbol_regex1)) {
        state.justMatchedKeyword = false;
        return "atom";
      } else if (stream.match(open_paren_regex)) {
        state.afterParen = true;
        state.justMatchedKeyword = true;
        return "def";
      } else if (stream.match(close_paren_regex)) {
        state.afterParen = false;
        state.justMatchedKeyword = true;
        return "def";
      } else if (stream.match(keyword_regex2)) {
        state.justMatchedKeyword = true;
        return "keyword";
      } else if (stream.eatSpace()) {
        state.justMatchedKeyword = false;
      } else {
        stream.next();
        if (state.justMatchedKeyword) {
          return "property";
        } else if (state.afterParen) {
          return "property";
        }
      }
      return null;
    }
  };
});
CodeMirror.defineMIME('text/x-jade', 'jade');
});
