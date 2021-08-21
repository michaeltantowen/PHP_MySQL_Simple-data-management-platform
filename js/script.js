$(document).ready(function() {
  $('#keyword').on('keyup', function() {
    $('#live-search').load('livesearch.php?keyword=' + $('#keyword').val());
  });
});