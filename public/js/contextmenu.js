
// Utility: Position and show a menu
// function positionAndShowMenu(menu, event) {
//   closeAllContainers();
//   const menuRect = menu[0].getBoundingClientRect();
//   const viewportWidth = $(window).width();
//   const viewportHeight = $(window).height();

//   let top = event.clientY;
//   let left = event.clientX;

//   // Adjust for viewport constraints
//   if (left + menuRect.width > viewportWidth) left -= menuRect.width;
//   if (top + menuRect.height > viewportHeight) top -= menuRect.height;

//   // Ensure positive values
//   top = Math.max(0, top);
//   left = Math.max(0, left);

//   menu.css({ top: `${top}px`, left: `${left}px`, visibility: 'visible' }).show();
// }

function positionAndShowMenu(menu, event) {
  closeAllContainers();
  menu.css("display", "block").css("visibility", "hidden");
  // Calculate positions and available space

  const menuRect = menu[0].getBoundingClientRect();
  const viewportWidth = $(window).width();
  const viewportHeight = $(window).height();

  // Initial positioning: Prioritize placing the menu to the right
  let top = event.clientY;
  let left = event.clientX;

  // Check if there's enough space on the right, accounting for a small margin
  if (left + menuRect.width + 10 < viewportWidth) {
    // If so, place it on the right
  } else {
    // If not enough space on the right, place it on the left
    left -= menuRect.width;
  }

  // Adjust if overflowing at the top
  if (top + menuRect.height > viewportHeight) {
    // Try placing above first
    top = event.clientY - menuRect.height;
    if (top < 0) {
      // If still overflowing, adjust to fit below
      top = Math.max(0, viewportHeight - menuRect.height);
    }
  }

  // Ensure the menu is within the screen
  top = Math.max(0, top);
  left = Math.max(0, left);

  menu.css({
    top: top + "px",
    left: left + "px",
    visibility: "visible"
  }).removeClass("hidden").css("display", "block");

}

// Utility: Close all containers except the specified one
function closeAllContainers(except = null) {
  $(".context-menu").not(except).hide();
  // $(".fimanagertoolpanel").addClass("disabledicon");
}

$(document).ready(function () {
  const appContextMenu = $("#app-contextmenu");
  const dashboardContextMenu = $("#context-menu");

  // Right Click: Show the appropriate context menu
  $(document).on("contextmenu", function (event) {
      $('#iframeheaders .iframetabselement').addClass('hidden');
    event.preventDefault();
    const target = $(event.target);

    if (target.closest(allAppListClass+" .app").length) {
      handleAppRightClick(target, event, appContextMenu);
    } else if (target.closest(allAppListClass).length) {
      handleDashboardRightClick(event, dashboardContextMenu);
    } else {
      closeAllContainers();
    }
  });

  // Left Click: Close all containers
  $(document).on("click", function (event) {
    if (!$(event.target).closest(".context-menu, "+allAppListClass).length) {
      closeAllContainers();
    }

    
  });

   //Submenu hover logic
  $(document).on("mouseenter", ".context-menu li", function () {
    const submenu = $(this).find(".submenu");
    if (submenu.length) handleSubmenuPosition(submenu, $(this));
  });

  $(document).on("mouseleave", ".context-menu li", function () {
    const submenu = $(this).find(".submenu");
    submenu.hide();
  });



  // App click logic
  console.log($(allAppListClass+' .app'));
  $(document).on("click", allAppListClass+ " .app .app-tools i", function (event) {
      event.preventDefault();
      event.stopPropagation();
      console.log("hllo");
    handleAppClick($(this), event, appContextMenu);
  });

  // Checkbox logic
  setupCheckboxLogic();
});


function handleAppRightClick(target, event, appContextMenu) {
  const app = target.closest(allAppListClass+" .app");
  const filetype = app.find(".selectapp").data("filetype");
  $(allAppListClass+" .app").removeClass("desktopapp-clicked selectedfile");
  app.find(".selectapp").addClass("selectedfile");

  if (filetype == "folder" || filetype == "file") {
    $(".filemamagertab .fimanagertoolpanel").removeClass("disabledicon");
  } else {
    $(".filemamagertab .fimanagertoolpanel").addClass("disabledicon");
  }
  $(".filemamagertab .enableonlypaste").addClass("disabledicon");

  contextMenuList(app.data("option"), appContextMenu);
  positionAndShowMenu(appContextMenu, event);
}

function handleDashboardRightClick(event, dashboardContextMenu) {

  $(".filemamagertab .fimanagertoolpanel").addClass("disabledicon");
  if(is_paste){
   $(".filemamagertab .enableonlypaste").removeClass("disabledicon");
  }
  contextMenuList("rightclick", dashboardContextMenu,path);
  positionAndShowMenu(dashboardContextMenu, event);
}

function handleAppClick(appTool, event, appContextMenu) {
  event.stopPropagation();
  const app = appTool.closest(".app");
  const filetype = app.closest(".openiframe").data("filetype");

  $(allAppListClass+" .app").removeClass("desktopapp-clicked selectedfile");
  app.addClass("desktopapp-clicked");
  app.find(".openiframe").addClass("selectedfile");
  if (filetype == "folder" || filetype == "file") {
    $(".filemamagertab .fimanagertoolpanel").removeClass("disabledicon");
  } else {
    $(".filemamagertab .fimanagertoolpanel").addClass("disabledicon");
  }
  $(".filemamagertab .enableonlypaste").addClass("disabledicon");

  contextMenuList(app.data("option"), appContextMenu);
  positionAndShowMenu(appContextMenu, event);
}

function handleSubmenuPosition(submenu, parent) {
  submenu.show();

  const submenuRect = submenu[0].getBoundingClientRect();
  const screenWidth = $(window).width();
  const screenHeight = $(window).height();

  // Adjust submenu position for overflow
  if (submenuRect.right > screenWidth) submenu.css("left", `-${submenuRect.width}px`);
  if (submenuRect.bottom > screenHeight) submenu.css("top", `-${submenuRect.height - parent.outerHeight()}px`);
}

function setupCheckboxLogic() {
  const container = $(allAppListClass);
$("#app-contextmenu").hide();
  $("#context-menu").hide();
  container.on("click", ".app", function (event) {
    event.stopPropagation();
    const checkbox = $(this).find('input[type="checkbox"]');
    checkbox.prop("checked", !checkbox.prop("checked"));
  });

  container.on("click", 'input[type="checkbox"]', function (event) {
    event.stopPropagation();
    
  });
}
/// end context menu
///ajax function 
function contextMenuList(type, menu,path=null) {
  $.ajax({
    url: contextmenu,
    method: "GET",
    data: { type,path },
    success: function (response) {
      menu.html(response.html).show();
    },
    error: function (xhr) {
      console.error("Error loading context menu:", xhr.responseText);
    }
  });
}