(function ($) {
  Drupal.behaviors.getTime = {
    attach: function (context, settings) {

      function fetchTimeData(cont, city) {
        // Make an AJAX request to the controller function route.
        $.ajax({
          url: '/get-clock/' + cont + '/' + city,
          type: 'GET',
          success: function (response) {
            // Handle the response from the controller function.
            $('#' + city).text(response.time);
          },
          error: function (xhr, status, error) {
            // Handle errors.
            console.error(error);
          }
        });
      }

      // Update time data every 1 minute for each clock instance
      $('.clock', context).each(function () {
        var cont = $(this).data('cont');
        var city = $(this).data('city');
        fetchTimeData(cont, city); // Initial fetch
        setInterval(function() {
          fetchTimeData(cont, city);
        }, 60000); // Fetch data every 1 minute
      });
    }
  };
})(jQuery);
