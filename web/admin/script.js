$(document).ready(function() {
  // Sidebar Animation
  $('.menu-item').click(function() {
      $('.menu-item').removeClass('active');
      $(this).addClass('active');
  });

  // Default content
  $('#contentFrame').attr('src', 'dashboard_default.php');
});

function changeTab(tabName) {
  var url = '';
  switch(tabName) {
      case 'Pizza':
          url = 'insert_pizza.php';
          break;
      case 'FastFood':
          url = 'insert_fastfood.php';
          break;
      case 'Chinese':
          url = 'insert_chinese.php';
          break;
      case 'Beverages':
          url = 'insert_bev.php';
          break;
      default:
          url = 'dashboard_default.php';
          break;
  }

  $('#contentFrame').attr('src', url);
}
