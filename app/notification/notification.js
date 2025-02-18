// Notification function
function notification({ title = "", mess = "", type = "info", duration = 2000 }) {
  const main = document.getElementById("noti");
  if (main) {
    const noti = document.createElement("div");

    // Auto remove noti
    const autoRemoveId = setTimeout(function () {
      main.removeChild(noti);
    }, duration + 1000);

    // Remove noti when clicked
    noti.onclick = function (e) {
      if (e.target.closest(".noti__close")) {
        main.removeChild(noti);
        clearTimeout(autoRemoveId);
      }
    };

    const icons = {
      success: "fas fa-check-circle",
      info: "fas fa-info-circle",
      warning: "fas fa-exclamation-circle",
      error: "fas fa-exclamation-circle"
    };
    const icon = icons[type];
    const delay = (duration / 1000).toFixed(2);

    noti.classList.add("noti", `noti--${type}`);
    noti.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

    noti.innerHTML = `
                      <div class="noti__icon">
                          <i class="${icon}"></i>
                      </div>
                      <div class="noti__body">
                          <h3 class="noti__title">${title}</h3>
                          <p class="noti__msg">${mess}</p>
                      </div>
                      <div class="noti__close">
                          <i class="fas fa-times"></i>
                      </div>
                  `;
    main.appendChild(noti);
  } else {
    console.log('Không tìm thấy thẻ thông báo!');
  }
}
