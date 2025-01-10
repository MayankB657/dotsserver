$('.custom-dropdown').each(function() {
  var $select = $(this).find('select');

  // Check if the custom elements already exist, if not, create them
  if ($(this).find('.select-selected').length === 0 && $(this).find('.select-items').length === 0) {
    var $selected = $('<div class="select-selected"></div>')
      .text($select.find('option:selected').text())
      .append('<span class="absolute right-3 top-2.5 font-bold arrow transform transition-transform"><i class="ri-arrow-down-s-line ri-lg"></i></span>');
    var $items = $('<div class="select-items select-hide overflow-y-auto max-h-16 scroll"></div>');

    // Create custom dropdown items for all options, including the first
    $select.find('option').each(function(index) {
      var $item = $('<div></div>').text($(this).text());

      // Handle custom item click
      $item.on('click', function() {
        var optionIndex = index; // Directly map to the current index
        $select.prop('selectedIndex', optionIndex); // Set the native select index
        $selected.text($(this).text()).append('<span class="absolute right-3 top-2.5 font-bold arrow transform transition-transform"><i class="ri-arrow-down-s-line ri-lg"></i></span>');
        ; // Update the custom selected text
        $select.trigger('change'); // Trigger change event on the native select

        // Mark the selected item visually
        $items.find('.same-as-selected').removeClass('same-as-selected');
        $(this).addClass('same-as-selected');

        // Hide the dropdown and remove the rotation
        $items.addClass('select-hide');
        $selected.removeClass('select-arrow-active');
        $selected.find('.arrow').removeClass('rotate-180'); // Remove rotation when closed
      });

      $items.append($item);
    });

    // Append the elements only once
    $(this).append($selected).append($items);

    // Add rounded classes to the first and last items for design purposes
    $items.children().first().addClass('rounded-t');
    $items.children().last().addClass('rounded-b');
  }

  // Toggle the dropdown on selected item click
  $(this).find('.select-selected').on('click', function(e) {
    e.stopPropagation();
    $('.select-selected').not($(this)).removeClass('select-arrow-active').next('.select-items').addClass('select-hide');
    $(this).toggleClass('select-arrow-active').next('.select-items').toggleClass('select-hide');

    // Rotate the arrow when the dropdown is opened
    $(this).find('.arrow').toggleClass('rotate-180');
  });
});

// Close dropdowns if clicking outside
$(document).on('click', function() {
  $('.select-selected').removeClass('select-arrow-active');
  $('.select-items').addClass('select-hide');
  $('.arrow').removeClass('rotate-180'); // Ensure the arrow resets when clicking outside
});
