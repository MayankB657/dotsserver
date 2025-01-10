//functionality of animation of apps openining

function handleClick() {
    setTimeout(() => {
        const iframe = document.querySelector('#box');
        togglePane('.popupiframe');
        iframe.classList.add('show');
    }, 1000);
}

document.addEventListener('DOMContentLoaded', () => {
    const downloadItems = document.querySelectorAll('.app');
    const toolbar = document.getElementById('toolbar');
    const box = document.getElementById("box");
    const minimizebtn = document.getElementById("minimizebtn");
    let minimized = false;

    downloadItems.forEach(item => {
        item.addEventListener('click', () => {
            const appId = item.getAttribute('data-app-id');
            const existingIcon = toolbar.querySelector(`img[data-app-id="${appId}"]`);

            if (!existingIcon) {
                const originalIcon = item.querySelector('img');
                const img = document.createElement('img');
                img.src = originalIcon.src;
                img.setAttribute('data-app-id', appId);
                img.classList.add('app-icon');
                animateIcon(img, originalIcon);
            }
        });
    });

    // toolbar.addEventListener('click', (event) => {
    //     const targetIcon = event.target.closest('img[data-app-id]');
    //     if (targetIcon) {
    //         if (minimized) {
    //             box.classList.remove('hidden');
    //             box.classList.remove('minimized');
    //             box.classList.add('fall-down');
    //             minimized = false;

    //             box.addEventListener('animationend', () => {
    //                 box.classList.remove('fall-down');
    //             }, { once: true });
    //         } else {
    //             animateIconDownward(targetIcon);
    //         }
    //     }
    // });

    function animateIcon(icon, originalIcon) {
        const rect = originalIcon.getBoundingClientRect();
        const toolbarRect = toolbar.getBoundingClientRect();
        const toolbarCenterX = toolbarRect.left + (toolbarRect.width / 2) - (rect.width / 2);
        const toolbarCenterY = toolbarRect.top + (toolbarRect.height / 2) - (rect.height / 2);

        const moveX = toolbarCenterX - rect.left;
        const moveY = toolbarCenterY - rect.top;

        const clone = originalIcon.cloneNode(true);
        clone.style.position = 'fixed';
        clone.style.left = `${rect.left}px`;
        clone.style.top = `${rect.top}px`;
        clone.style.width = `${rect.width}px`;
        clone.style.height = `${rect.height}px`;
        clone.style.setProperty('--move-x', `${moveX}px`);
        clone.style.setProperty('--move-y', `${moveY}px`);
        clone.classList.add('moving-to-top');
        document.body.appendChild(clone);

        clone.addEventListener('animationend', () => {
            clone.remove();
            toolbar.appendChild(icon);
            animateIconToCenter(icon);
        });
    }


    function animateIconToCenter(icon) {
        icon.style.opacity = 0;
        setTimeout(() => {
            icon.style.transition = 'opacity 0.5s, transform 0.5s';
            icon.style.opacity = 1;
            icon.style.transform = 'translateY(0)';
        }, 10);
    }


    // minimizebtn.addEventListener("click", function () {
    //     const appId = box.getAttribute('data-app-id');
    //     const targetIcon = toolbar.querySelector(`img[data-app-id="${appId}"]`);

    //     if (targetIcon) {
    //         if (!box.classList.contains("minimized")) {
    //             box.classList.add("minimized");
    //             minimized = true;
    //             setTimeout(() => {
    //                 box.classList.add('hidden');
    //             }, 600);
    //         }
    //     }
    // });

    // const closeiframeBtns = document.querySelectorAll('.closeiframe-btn');
    // closeiframeBtns.forEach(btn => {
    //     btn.addEventListener('click', function () {
    //         const filekey = this.getAttribute('data-app-id');
    //         const toolbarIcon = toolbar.querySelector(`img[data-app-id="${filekey}"]`);
    //         if (toolbarIcon) {
    //             toolbarIcon.remove();
    //         }
    //     });
    // });
});