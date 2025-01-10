const desktopSteps = [{
    title: "Welcome to the Dots! 👋",
    content: "We're excited to have you here. Click on next to Start the Tour of our website",
    target: "body",
}, {
    title: "Taskbar",
    content: "The taskbar shows icons for all the apps or windows you currently have open. You can easily switch between them by clicking on the respective icon.",
    target: ".navbar",
    dialogTarget: ".navbar",
    group: "groupA"
}, {
    title: "Search Icon",
    content: "Click to search files and folders on your desktop.",
    target: "#search-icon",
    group: "groupA",
}, {
    title: "Notification Icon",
    content: "View recent notifications and updates here.",
    target: "#notification-icon",
    group: "groupA",
}, {
    title: "Desktop Apps",
    content: "Manage Your Desktop apps here.",
    target: ".desktop-apps",
},
{
    title: "Apps Context Menu",
    content: "Right-click on any app to access additional options and settings through the context menu.",
    target: '[data-appkey="Ng"]',

},
{
    title: "Desktop Context Menu",
    content: "Right-click anywhere on the desktop to quickly access options like refreshing, uploading files, creating new folders or files, and customizing your workspace. Explore additional settings under 'More' for further desktop customization.",
    target: "#context-menu",
    beforeEnter: () => {
        function triggerRightClick(selector) {
            var event = new $.Event("contextmenu");
            $(selector).trigger(event);
            const menu = document.getElementById("context-menu");
            if (menu) {
                menu.style.top = "40%";
                menu.style.left = "50%";
                menu.style.display = "block";
            }
        }
        triggerRightClick(".allapplist");
    },
    afterLeave: () => {
        const menu = document.getElementById("context-menu");
        if (menu) {
            menu.style.display = "none"; // Hide the menu when leaving
        }
    }

},
{
    title: " App Context Menu Options",
    content: "Right-click on an app to explore a variety of actions including opening, copying, and tagging. Access additional features like compressing files, managing attributes, and more.",
    target: "#app-contextmenu",
    beforeEnter: () => {
        function triggerRightClick(selector) {
            var event = $.Event("contextmenu");
            $(selector).trigger(event);

            const appMenu = document.getElementById("app-contextmenu");
            if (appMenu) {
                appMenu.style.top = "40%";
                appMenu.style.left = "50%";
                appMenu.style.display = "block";
            }
        }

        triggerRightClick(".allapplist .app:last");
    },
    afterLeave: () => {
        const appMenu = document.getElementById("app-contextmenu");
        if (appMenu) {
            appMenu.style.display = "none";
        }
    }
},
{
    title: "System Apps",
    content: "Access essential system apps to manage your device and optimize.",
    target: ".dashboard-sidebar"
},
{
    title: "Dots Logo",
    content: "Click on the logo to access the administrator panel.",
    target: "#footer-logo",
},
{
    title: "Administrator",
    content: "A quick-access menu for admins to manage files, users, plugins and system info",
    target: "#administrator",
    beforeEnter: () => {
        document.getElementById("administrator").classList.remove("hidden")
    },
    afterLeave: () => {
        document.getElementById("administrator").classList.add("hidden")
    },
    order: "",

}
]

const tg = new tourguide.TourGuideClient({
    steps: desktopSteps,
    completeOnFinish: true,
    allowDialogOverlap: true,
    exitOnClickOutside: true,
})

function startGuide() {
    tg.start()
}
