(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.Clock = {
    attach: function (context, settings) {
      // Function to get the time string from a dateTimeString
      function getTimeString(dateTimeString) {
        // Using regular expression to match the time portion (HH:MM)
        const timeMatch = dateTimeString.match(/\d{2}:\d{2}/);
        return timeMatch ? timeMatch[0] : null; // Returning the matched time string or null if no time string found
      }

      // Function to update the clock
      function fetchTimeData(timezone) {
        fetch('https://worldclockapi.com/api/json/' + timezone + '/now')
          .then(response => response.json())
          .then(data => {
            const currentTime = data.currentDateTime.split('T')[1].replace('Z', '');
            $('#' + timezone).text(getTimeString(currentTime));
          })
          .catch(error => {
            console.error('Error fetching time data:', error);
          });
      }

      // Update time data every 1 minute for each clock instance
      $('.clock', context).each(function () {
        var timezone = $(this).data('unique-id');
        fetchTimeData(timezone); // Initial fetch
        setInterval(function() {
          fetchTimeData(timezone);
        }, 60000); // Fetch data every 1 minute
      });
    }
  };
})(jQuery, Drupal);
