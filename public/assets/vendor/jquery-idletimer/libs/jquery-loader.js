(function() {
  var path = '../libs/jquery/jquery.js';
  var jqversion = location.search.match(/[?&]jquery=(.*?)(?=&|$)/);
  if (jqversion) {
    path = 'http:
  }
  document.write('<script src="' + path + '"></script>');
}());
