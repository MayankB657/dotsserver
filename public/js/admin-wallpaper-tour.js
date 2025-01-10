// Steps for tour
const steps = [
  {
    content:
      "This page allows administrators to manage and customize wallpapers for both desktop and login screens.",
    title: "Welcome to Administrator Wallpaper Tour! 👋",
    target: "body",
  },
  ...(isMobile()
    ? []
    : [
        {
          content:
            "Accessing different settings, and a central area for wallpaper customization.",
          title: "Wallpaper Tab",
          target: "#wallpaper",
        },
      ]),
  {
    content:
      "Toggle between 'Desktop' and 'Login' tabs to customize wallpapers for each context.",
    title: "Wallpaper Management Section",
    target: ".tabs",
  },
  {
    content: "Click the plus icon to upload a new wallpaper from your device.",
    title: "Add New Wallpaper",
    target: "#add-div",
  },
  {
    content:
      "Select a wallpaper by clicking on any image from the grid. The selected image will be applied.",
    title: "Wallpaper Selection",
    target: ".wallpapers",
  },
  {
    content: "Click 'Save' to confirm and apply your selected wallpaper.",
    title: "Save Button",
    target: ".save",
  },
];

// Function to check if the screen is mobile
function isMobile() {
  return window.innerWidth <= 768;
}

// Initialize a new TourGuideClient with custom configuration
const tg = new tourguide.TourGuideClient({
  steps: steps,
  completeOnFinish: true,
  allowDialogOverlap: true,
  exitOnClickOutside: true,
  rememberStep: true,
});

// Start the tour guide
function startGuide() {
  tg.start();
}