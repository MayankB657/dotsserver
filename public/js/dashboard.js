///// desktopjs
       /// dots logo admin click
       function closeotherContainers(except = null) {
        for (let key in allothercontainers) {
          if (allothercontainers[key] !== except) {
            allothercontainers[key].classList.add("hidden");
          }
        }
      }

       const allothercontainers = {
        notification: document.getElementById("NotiContainer"),
        search: document.getElementById("search"),
        administrator: document.getElementById("administrator"),
};
        
      //Administrator Panel click

       document.getElementById("footer-logo").addEventListener("click", function (event) {
        event.stopPropagation();
        if (allothercontainers.administrator.classList.contains("hidden")) {
            closeotherContainers(allothercontainers.administrator);
        }
        allothercontainers.administrator.classList.toggle("hidden");
         // Hide context menus
        hideContextMenus()
       });

      //  Notification icon click

      document.getElementById("notification-icon").addEventListener("click", function (event) {
        event.stopPropagation();
        if (allothercontainers.notification.classList.contains("hidden")) {
            closeotherContainers(allothercontainers.notification);
        }
        allothercontainers.notification.classList.toggle("hidden");
         // Hide context menus
        hideContextMenus()
       });
      
      function hideContextMenus() {
        const appContextMenu = document.getElementById("app-contextmenu");
        const dashboardContextMenu = document.getElementById("context-menu");

        appContextMenu.classList.add("hidden");
        dashboardContextMenu.classList.add("hidden");
        appContextMenu.style.display = "none";
        dashboardContextMenu.style.display = "none";
      }

      /// end



        //Clock Functionality
        function updateClock() {
            const clock = document.getElementById("clock");
            const now = new Date();

            const hours = String(now.getHours()).padStart(2, "0");
            const minutes = String(now.getMinutes()).padStart(2, "0");

            const days = [
              "Sun",
              "Mon",
              "Tue",
              "Wed",
              "Thu",
              "Fri",
              "Sat",
            ];
            const months = [
              "January",
              "February",
              "March",
              "April",
              "May",
              "June",
              "July",
              "August",
              "September",
              "October",
              "November",
              "December",
            ];
            const day = days[now.getDay()];
            const month = months[now.getMonth()];
            const date = now.getDate();

            const timeString = `${hours}:${minutes}`;
            const dateString = `${day}, ${month} ${date}`;

            clock.innerHTML = `<div class="time text-c-black text-2xl font-normal">${timeString}</div><div class="date text-sm flex font-normal">${dateString}</div>`;
          }

          updateClock();
          setInterval(updateClock, 60000);


          //Search Contiainer Functionality
          const searchInput = document.getElementById("searchInput");
          const suggestions = document.getElementById("searchsuggestions");
          const Search = document.querySelector(".Search")

          searchInput.addEventListener("input", function () {
        if (searchInput.value.length > 0) {
          suggestions.classList.remove("hidden");
          Search.classList.add("open");
        } else {
          suggestions.classList.add("hidden");
          Search.classList.remove("open");
        }
      });
          document
            .querySelector(".cross-icon")
            .addEventListener("click", function () {
              searchInput.value = "";
              suggestions.classList.add("hidden");
              Search.classList.remove("open");
              document.getElementById("search").classList.add("hidden");
            });

            document.getElementById("search-icon").addEventListener("click", function (event) {
                event.stopPropagation();
                document.getElementById('searchInput').value = '';
                if (allothercontainers.search.classList.contains("hidden")) {
                    closeotherContainers(allothercontainers.search);
                }
                allothercontainers.search.classList.toggle("hidden");

                 // Hide context menus
                hideContextMenus()
            });

document.addEventListener("click", function (event) {
  if (!event.target.closest("#NotiContainer") && !event.target.closest("#search") && !event.target.closest("#administrator")) {
    closeotherContainers();
  }
});

          // draggble clock functionality
        dragElement(document.getElementById("clock"));

        function dragElement(element) {
          let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
          element.onmousedown = dragMouseDown;

          function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
          }

          function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;

            // set the element's new position:
            const newTop = element.offsetTop - pos2;
            const newLeft = element.offsetLeft - pos1;

            // prevent the element from being dragged out of the screen
            const minTop = 0;
            const maxTop = window.innerHeight - element.offsetHeight;
            const minLeft = 0;
            const maxLeft = window.innerWidth - element.offsetWidth;

            element.style.top = Math.min(Math.max(newTop, minTop), maxTop) + "px";
            element.style.left = Math.min(Math.max(newLeft, minLeft), maxLeft) + "px";
          }

          function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
          }
        }


