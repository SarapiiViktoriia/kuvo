(function() {
  var mode = CodeMirror.getMode({tabSize: 4}, "markdown");
  function MT(name) { test.mode(name, mode, Array.prototype.slice.call(arguments, 1)); }
  var modeHighlightFormatting = CodeMirror.getMode({tabSize: 4}, {name: "markdown", highlightFormatting: true});
  function FT(name) { test.mode(name, modeHighlightFormatting, Array.prototype.slice.call(arguments, 1)); }
  FT("formatting_emAsterisk",
     "[em&formatting&formatting-em *][em foo][em&formatting&formatting-em *]");
  FT("formatting_emUnderscore",
     "[em&formatting&formatting-em _][em foo][em&formatting&formatting-em _]");
  FT("formatting_strongAsterisk",
     "[strong&formatting&formatting-strong **][strong foo][strong&formatting&formatting-strong **]");
  FT("formatting_strongUnderscore",
     "[strong&formatting&formatting-strong __][strong foo][strong&formatting&formatting-strong __]");
  FT("formatting_codeBackticks",
     "[comment&formatting&formatting-code `][comment foo][comment&formatting&formatting-code `]");
  FT("formatting_doubleBackticks",
     "[comment&formatting&formatting-code ``][comment foo ` bar][comment&formatting&formatting-code ``]");
  FT("formatting_atxHeader",
     "[header&header-1&formatting&formatting-header&formatting-header-1 #][header&header-1  foo # bar ][header&header-1&formatting&formatting-header&formatting-header-1 #]");
  FT("formatting_setextHeader",
     "foo",
     "[header&header-1&formatting&formatting-header&formatting-header-1 =]");
  FT("formatting_blockquote",
     "[quote&quote-1&formatting&formatting-quote&formatting-quote-1 > ][quote&quote-1 foo]");
  FT("formatting_list",
     "[variable-2&formatting&formatting-list&formatting-list-ul - ][variable-2 foo]");
  FT("formatting_list",
     "[variable-2&formatting&formatting-list&formatting-list-ol 1. ][variable-2 foo]");
  FT("formatting_link",
     "[link&formatting&formatting-link [][link foo][link&formatting&formatting-link ]]][string&formatting&formatting-link-string (][string http:
  FT("formatting_linkReference",
     "[link&formatting&formatting-link [][link foo][link&formatting&formatting-link ]]][string&formatting&formatting-link-string [][string bar][string&formatting&formatting-link-string ]]]",
     "[link&formatting&formatting-link [][link bar][link&formatting&formatting-link ]]:] [string http:
  FT("formatting_linkWeb",
     "[link&formatting&formatting-link <][link http:
  FT("formatting_linkEmail",
     "[link&formatting&formatting-link <][link user@example.com][link&formatting&formatting-link >]");
  FT("formatting_escape",
     "[formatting&formatting-escape \\]*");
  MT("plainText",
     "foo");
  MT("trailingSpace1",
     "foo ");
  MT("trailingSpace2",
     "foo[trailing-space-a  ][trailing-space-new-line  ]");
  MT("trailingSpace3",
     "foo[trailing-space-a  ][trailing-space-b  ][trailing-space-new-line  ]");
  MT("trailingSpace4",
     "foo[trailing-space-a  ][trailing-space-b  ][trailing-space-a  ][trailing-space-new-line  ]");
  MT("codeBlocksUsing4Spaces",
     "    [comment foo]");
  MT("codeBlocksUsing4SpacesIndentation",
     "    [comment bar]",
     "        [comment hello]",
     "            [comment world]",
     "    [comment foo]",
     "bar");
  MT("codeBlocksUsing4SpacesIndentation",
     " foo",
     "    [comment bar]",
     "        [comment hello]",
     "    [comment world]");
  MT("codeBlocksUsing1Tab",
     "\t[comment foo]");
  MT("inlineCodeUsingBackticks",
     "foo [comment `bar`]");
  MT("blockCodeSingleBacktick",
     "[comment `]",
     "foo",
     "[comment `]");
  MT("unclosedBackticks",
     "foo [comment `bar]");
  MT("doubleBackticks",
     "[comment ``foo ` bar``]");
  MT("consecutiveBackticks",
     "[comment `foo```bar`]");
  MT("consecutiveBackticks",
     "[comment `foo```bar`] hello [comment `world`]");
  MT("unclosedBackticks",
     "[comment ``foo ``` bar` hello]");
  MT("closedBackticks",
     "[comment ``foo ``` bar` hello``] world");
  MT("atxH1",
     "[header&header-1 # foo]");
  MT("atxH2",
     "[header&header-2 ## foo]");
  MT("atxH3",
     "[header&header-3 ### foo]");
  MT("atxH4",
     "[header&header-4 #### foo]");
  MT("atxH5",
     "[header&header-5 ##### foo]");
  MT("atxH6",
     "[header&header-6 ###### foo]");
  MT("atxH6NotH7",
     "[header&header-6 ####### foo]");
  MT("atxH1inline",
     "[header&header-1 # foo ][header&header-1&em *bar*]");
  MT("setextH1",
     "foo",
     "[header&header-1 =]");
  MT("setextH1",
     "foo",
     "[header&header-1 ===]");
  MT("setextH2",
     "foo",
     "[header&header-2 -]");
  MT("setextH2",
     "foo",
     "[header&header-2 ---]");
  MT("blockquoteSpace",
     "[quote&quote-1 > foo]");
  MT("blockquoteNoSpace",
     "[quote&quote-1 >foo]");
  MT("blockquoteNoBlankLine",
     "foo",
     "[quote&quote-1 > bar]");
  MT("blockquoteSpace",
     "[quote&quote-1 > foo]",
     "[quote&quote-1 >][quote&quote-2 > foo]",
     "[quote&quote-1 >][quote&quote-2 >][quote&quote-3 > foo]");
  MT("blockquoteThenParagraph",
     "[quote&quote-1 >foo]",
     "",
     "bar");
  MT("multiBlockquoteLazy",
     "[quote&quote-1 >foo]",
     "[quote&quote-1 bar]");
  MT("multiBlockquoteLazyThenParagraph",
     "[quote&quote-1 >foo]",
     "[quote&quote-1 bar]",
     "",
     "hello");
  MT("multiBlockquote",
     "[quote&quote-1 >foo]",
     "[quote&quote-1 >bar]");
  MT("multiBlockquoteThenParagraph",
     "[quote&quote-1 >foo]",
     "[quote&quote-1 >bar]",
     "",
     "hello");
  MT("listAsterisk",
     "foo",
     "bar",
     "",
     "[variable-2 * foo]",
     "[variable-2 * bar]");
  MT("listPlus",
     "foo",
     "bar",
     "",
     "[variable-2 + foo]",
     "[variable-2 + bar]");
  MT("listDash",
     "foo",
     "bar",
     "",
     "[variable-2 - foo]",
     "[variable-2 - bar]");
  MT("listNumber",
     "foo",
     "bar",
     "",
     "[variable-2 1. foo]",
     "[variable-2 2. bar]");
  MT("listBogus",
     "foo",
     "1. bar",
     "2. hello");
  MT("listAfterHeader",
     "[header&header-1 # foo]",
     "[variable-2 - bar]");
  MT("listAsteriskFormatting",
     "[variable-2 * ][variable-2&em *foo*][variable-2  bar]",
     "[variable-2 * ][variable-2&strong **foo**][variable-2  bar]",
     "[variable-2 * ][variable-2&strong **][variable-2&em&strong *foo**][variable-2&em *][variable-2  bar]",
     "[variable-2 * ][variable-2&comment `foo`][variable-2  bar]");
  MT("listPlusFormatting",
     "[variable-2 + ][variable-2&em *foo*][variable-2  bar]",
     "[variable-2 + ][variable-2&strong **foo**][variable-2  bar]",
     "[variable-2 + ][variable-2&strong **][variable-2&em&strong *foo**][variable-2&em *][variable-2  bar]",
     "[variable-2 + ][variable-2&comment `foo`][variable-2  bar]");
  MT("listDashFormatting",
     "[variable-2 - ][variable-2&em *foo*][variable-2  bar]",
     "[variable-2 - ][variable-2&strong **foo**][variable-2  bar]",
     "[variable-2 - ][variable-2&strong **][variable-2&em&strong *foo**][variable-2&em *][variable-2  bar]",
     "[variable-2 - ][variable-2&comment `foo`][variable-2  bar]");
  MT("listNumberFormatting",
     "[variable-2 1. ][variable-2&em *foo*][variable-2  bar]",
     "[variable-2 2. ][variable-2&strong **foo**][variable-2  bar]",
     "[variable-2 3. ][variable-2&strong **][variable-2&em&strong *foo**][variable-2&em *][variable-2  bar]",
     "[variable-2 4. ][variable-2&comment `foo`][variable-2  bar]");
  MT("listParagraph",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]");
  MT("listMultiParagraph",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "    [variable-2 hello]");
  MT("listMultiParagraphExtra",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "",
     "    [variable-2 hello]");
  MT("listMultiParagraphExtraSpace",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "     [variable-2 hello]",
     "",
     "    [variable-2 world]");
  MT("listTab",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "\t[variable-2 hello]");
  MT("listNoIndent",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "hello");
  MT("blockquote",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "    [variable-2&quote&quote-1 > hello]");
  MT("blockquoteCode",
     "[variable-2 * foo]",
     "",
     "[variable-2 * bar]",
     "",
     "        [comment > hello]",
     "",
     "    [variable-2 world]");
  MT("blockquoteCodeText",
     "[variable-2 * foo]",
     "",
     "    [variable-2 bar]",
     "",
     "        [comment hello]",
     "",
     "    [variable-2 world]");
  MT("listAsteriskNested",
     "[variable-2 * foo]",
     "",
     "    [variable-3 * bar]");
  MT("listPlusNested",
     "[variable-2 + foo]",
     "",
     "    [variable-3 + bar]");
  MT("listDashNested",
     "[variable-2 - foo]",
     "",
     "    [variable-3 - bar]");
  MT("listNumberNested",
     "[variable-2 1. foo]",
     "",
     "    [variable-3 2. bar]");
  MT("listMixed",
     "[variable-2 * foo]",
     "",
     "    [variable-3 + bar]",
     "",
     "        [keyword - hello]",
     "",
     "            [variable-2 1. world]");
  MT("listBlockquote",
     "[variable-2 * foo]",
     "",
     "    [variable-3 + bar]",
     "",
     "        [quote&quote-1&variable-3 > hello]");
  MT("listCode",
     "[variable-2 * foo]",
     "",
     "    [variable-3 + bar]",
     "",
     "            [comment hello]");
  MT("listCodeIndentation",
     "[variable-2 * foo]",
     "",
     "        [comment bar]",
     "            [comment hello]",
     "                [comment world]",
     "        [comment foo]",
     "    [variable-2 bar]");
  MT("listNested",
    "[variable-2 * foo]",
    "",
    "    [variable-3 * bar]",
    "",
    "       [variable-2 hello]"
  );
  MT("listNested",
    "[variable-2 * foo]",
    "",
    "    [variable-3 * bar]",
    "",
    "      [variable-3 * foo]"
  );
  MT("listCodeText",
     "[variable-2 * foo]",
     "",
     "        [comment bar]",
     "",
     "hello");
  MT("hrSpace",
     "[hr * * *]");
  MT("hr",
     "[hr ***]");
  MT("hrLong",
     "[hr *****]");
  MT("hrSpaceDash",
     "[hr - - -]");
  MT("hrDashLong",
     "[hr ---------------------------------------]");
  MT("linkTitle",
     "[link [[foo]]][string (http:
  MT("linkNoTitle",
     "[link [[foo]]][string (http:
  MT("linkImage",
     "[link [[][tag ![[foo]]][string (http:
  MT("linkEm",
     "[link [[][link&em *foo*][link ]]][string (http:
  MT("linkStrong",
     "[link [[][link&strong **foo**][link ]]][string (http:
  MT("linkEmStrong",
     "[link [[][link&strong **][link&em&strong *foo**][link&em *][link ]]][string (http:
  MT("imageTitle",
     "[tag ![[foo]]][string (http:
  MT("imageNoTitle",
     "[tag ![[foo]]][string (http:
  MT("imageAsterisks",
     "[tag ![[*foo*]]][string (http:
  MT("notALink",
     "[[foo]] (bar)");
  MT("linkReference",
     "[link [[foo]]][string [[bar]]] hello");
  MT("linkReferenceEm",
     "[link [[][link&em *foo*][link ]]][string [[bar]]] hello");
  MT("linkReferenceStrong",
     "[link [[][link&strong **foo**][link ]]][string [[bar]]] hello");
  MT("linkReferenceEmStrong",
     "[link [[][link&strong **][link&em&strong *foo**][link&em *][link ]]][string [[bar]]] hello");
  MT("linkReferenceSpace",
     "[link [[foo]]] [string [[bar]]] hello");
  MT("linkReferenceDoubleSpace",
     "[[foo]]  [[bar]] hello");
  MT("linkImplicit",
     "[link [[foo]]][string [[]]] hello");
  MT("labelNoTitle",
     "[link [[foo]]:] [string http:
  MT("labelIndented",
     "   [link [[foo]]:] [string http:
  MT("labelSpaceTitle",
     "[link [[foo bar]]:] [string http:
  MT("labelDoubleTitle",
     "[link [[foo bar]]:] [string http:
  MT("labelTitleDoubleQuotes",
     "[link [[foo]]:] [string http:
  MT("labelTitleSingleQuotes",
     "[link [[foo]]:] [string http:
  MT("labelTitleParenthese",
     "[link [[foo]]:] [string http:
  MT("labelTitleInvalid",
     "[link [[foo]]:] [string http:
  MT("labelLinkAngleBrackets",
     "[link [[foo]]:] [string <http:
  MT("labelTitleNextDoubleQuotes",
     "[link [[foo]]:] [string http:
     "[string \"bar\"] hello");
  MT("labelTitleNextSingleQuotes",
     "[link [[foo]]:] [string http:
     "[string 'bar'] hello");
  MT("labelTitleNextParenthese",
     "[link [[foo]]:] [string http:
     "[string (bar)] hello");
  MT("labelTitleNextMixed",
     "[link [[foo]]:] [string http:
     "(bar\" hello");
  MT("linkWeb",
     "[link <http:
  MT("linkWebDouble",
     "[link <http:
  MT("linkEmail",
     "[link <user@example.com>] foo");
  MT("linkEmailDouble",
     "[link <user@example.com>] foo [link <user@example.com>]");
  MT("emAsterisk",
     "[em *foo*] bar");
  MT("emUnderscore",
     "[em _foo_] bar");
  MT("emInWordAsterisk",
     "foo[em *bar*]hello");
  MT("emInWordUnderscore",
     "foo[em _bar_]hello");
  MT("emEscapedBySpaceIn",
     "foo [em _bar _ hello_] world");
  MT("emEscapedBySpaceOut",
     "foo _ bar[em _hello_]world");
  MT("emEscapedByNewline",
     "foo",
     "_ bar[em _hello_]world");
  MT("emIncompleteAsterisk",
     "foo [em *bar]");
  MT("emIncompleteUnderscore",
     "foo [em _bar]");
  MT("strongAsterisk",
     "[strong **foo**] bar");
  MT("strongUnderscore",
     "[strong __foo__] bar");
  MT("emStrongAsterisk",
     "[em *foo][em&strong **bar*][strong hello**] world");
  MT("emStrongUnderscore",
     "[em _foo][em&strong __bar_][strong hello__] world");
  MT("emStrongMixed",
     "[em _foo][em&strong **bar*hello__ world]");
  MT("emStrongMixed",
     "[em *foo][em&strong __bar_hello** world]");
  MT("escapeBacktick",
     "foo \\`bar\\`");
  MT("doubleEscapeBacktick",
     "foo \\\\[comment `bar\\\\`]");
  MT("escapeAsterisk",
     "foo \\*bar\\*");
  MT("doubleEscapeAsterisk",
     "foo \\\\[em *bar\\\\*]");
  MT("escapeUnderscore",
     "foo \\_bar\\_");
  MT("doubleEscapeUnderscore",
     "foo \\\\[em _bar\\\\_]");
  MT("escapeHash",
     "\\# foo");
  MT("doubleEscapeHash",
     "\\\\# foo");
  MT("escapeNewline",
     "\\",
     "[em *foo*]");
  MT("taskList",
     "[variable-2 * [ ]] bar]");
  MT("fencedCodeBlocks",
     "[comment ```]",
     "foo",
     "[comment ```]");
})();
