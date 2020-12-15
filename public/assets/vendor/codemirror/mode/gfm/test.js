(function() {
  var mode = CodeMirror.getMode({tabSize: 4}, "gfm");
  function MT(name) { test.mode(name, mode, Array.prototype.slice.call(arguments, 1)); }
  var modeHighlightFormatting = CodeMirror.getMode({tabSize: 4}, {name: "gfm", highlightFormatting: true});
  function FT(name) { test.mode(name, modeHighlightFormatting, Array.prototype.slice.call(arguments, 1)); }
  FT("codeBackticks",
     "[comment&formatting&formatting-code `][comment foo][comment&formatting&formatting-code `]");
  FT("doubleBackticks",
     "[comment&formatting&formatting-code ``][comment foo ` bar][comment&formatting&formatting-code ``]");
  FT("codeBlock",
     "[comment&formatting&formatting-code-block ```css]",
     "[tag foo]",
     "[comment&formatting&formatting-code-block ```]");
  FT("taskList",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][meta&formatting&formatting-task [ ]]][variable-2  foo]",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][property&formatting&formatting-task [x]]][variable-2  foo]");
  MT("emInWordAsterisk",
     "foo[em *bar*]hello");
  MT("emInWordUnderscore",
     "foo_bar_hello");
  MT("emStrongUnderscore",
     "[strong __][em&strong _foo__][em _] bar");
  MT("fencedCodeBlocks",
     "[comment ```]",
     "[comment foo]",
     "",
     "[comment ```]",
     "bar");
  MT("fencedCodeBlockModeSwitching",
     "[comment ```javascript]",
     "[variable foo]",
     "",
     "[comment ```]",
     "bar");
  MT("taskListAsterisk",
     "[variable-2 * []] foo]", 
     "[variable-2 * [ ]]bar]", 
     "[variable-2 * [x]]hello]", 
     "[variable-2 * ][meta [ ]]][variable-2  [world]]]", 
     "    [variable-3 * ][property [x]]][variable-3  foo]"); 
  MT("taskListPlus",
     "[variable-2 + []] foo]", 
     "[variable-2 + [ ]]bar]", 
     "[variable-2 + [x]]hello]", 
     "[variable-2 + ][meta [ ]]][variable-2  [world]]]", 
     "    [variable-3 + ][property [x]]][variable-3  foo]"); 
  MT("taskListDash",
     "[variable-2 - []] foo]", 
     "[variable-2 - [ ]]bar]", 
     "[variable-2 - [x]]hello]", 
     "[variable-2 - ][meta [ ]]][variable-2  [world]]]", 
     "    [variable-3 - ][property [x]]][variable-3  foo]"); 
  MT("taskListNumber",
     "[variable-2 1. []] foo]", 
     "[variable-2 2. [ ]]bar]", 
     "[variable-2 3. [x]]hello]", 
     "[variable-2 4. ][meta [ ]]][variable-2  [world]]]", 
     "    [variable-3 1. ][property [x]]][variable-3  foo]"); 
  MT("SHA",
     "foo [link be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] bar");
  MT("shortSHA",
     "foo [link be6a8cc] bar");
  MT("tooShortSHA",
     "foo be6a8c bar");
  MT("longSHA",
     "foo be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd22 bar");
  MT("badSHA",
     "foo be6a8cc1c1ecfe9489fb51e4869af15a13fc2cg2 bar");
  MT("userSHA",
     "foo [link bar@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] hello");
  MT("userProjectSHA",
     "foo [link bar/hello@be6a8cc1c1ecfe9489fb51e4869af15a13fc2cd2] world");
  MT("num",
     "foo [link #1] bar");
  MT("badNum",
     "foo #1bar hello");
  MT("userNum",
     "foo [link bar#1] hello");
  MT("userProjectNum",
     "foo [link bar/hello#1] world");
  MT("vanillaLink",
     "foo [link http:
  MT("vanillaLinkPunctuation",
     "foo [link http:
  MT("vanillaLinkExtension",
     "foo [link http:
  MT("notALink",
     "[comment ```css]",
     "[tag foo] {[property color]:[keyword black];}",
     "[comment ```][link http:
  MT("notALink",
     "[comment ``foo `bar` http:
  MT("notALink",
     "[comment `foo]",
     "[link http:
     "[comment `foo]",
     "",
     "[link http:
})();
