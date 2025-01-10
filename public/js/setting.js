function toggleDropdown(id) {
            var dropdownOptions = document.getElementById(id);
            var allDropdowns = document.querySelectorAll('.dropdown-options');

            allDropdowns.forEach(function (dropdown) {
                if (dropdown.id !== id) {
                    dropdown.style.display = 'none';
                }
            });

            if (dropdownOptions.style.display === 'none') {
                dropdownOptions.style.display = 'block';
            } else {
                dropdownOptions.style.display = 'none';
            }

            // Toggle active class on button
            var dropdownButton = document.getElementById(id.replace('dropdownOptions-', 'dropdownButton-'));
            var allDropdownButtons = document.querySelectorAll('.dropdown-toggle');

            allDropdownButtons.forEach(function (button) {
                if (button.id !== dropdownButton.id) {
                    button.classList.remove('dropdown-button-active');
                }
            });

            dropdownButton.classList.toggle('dropdown-button-active');
        }

        function setActive(elementId) {
            // Remove active class from all dropdown items
            var dropdownItems = document.getElementsByClassName('dropdown-item');
            for (var i = 0; i < dropdownItems.length; i++) {
                dropdownItems[i].classList.remove('dropdown-item-active');
            }

            // Add active class to the clicked dropdown item
            var clickedItem = document.getElementById(elementId);
            clickedItem.classList.add('dropdown-item-active');
        }
        
         

        // Function to toggle the popup
        function togglePopup(popupId) {
            var popup = document.getElementById(popupId);
            if (popup) {
                popup.classList.toggle('hidden');
            } else {
                console.error('Popup with id ' + popupId + ' not found.');
            }
        }
