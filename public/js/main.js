
function fetchAndApplyTheme() {
    
    $.ajax({
        url: getthemeroute,
        type: "GET",
        success: function (response) {
            const theme = response.theme_json;
            const additionalWallpapers = response.additional_wallpapers;

            function updateCSSVariables(data) {
                for (const key in data) {
                    document.documentElement.style.setProperty(key, data[key]);
                }
            }

            if (theme) {
                updateCSSVariables(theme);
            }

            if (additionalWallpapers) {
                updateCSSVariables(additionalWallpapers);
            }

            const themeData = {
                id: response.theme_id,
                name: response.theme_name,
                theme_json: theme,
                wallpapers: additionalWallpapers || null,
            };

            localStorage.setItem('user_theme', JSON.stringify(themeData));
        },
        error: function () {
            console.log("No theme found for this user.");
        }
    });
}

function applySavedTheme() {
    const savedTheme = localStorage.getItem('user_theme');
    if (savedTheme) {
        const themeData = JSON.parse(savedTheme);

        function updateCSSVariables(data) {
            for (const key in data) {
                document.documentElement.style.setProperty(key, data[key]);
            }
        }

        if (themeData.theme_json) {
            updateCSSVariables(themeData.theme_json);
        }

        if (themeData.wallpapers) {
            updateCSSVariables(themeData.wallpapers);
        }
    }
}


    applySavedTheme();
    
    
            
