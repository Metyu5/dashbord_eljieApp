document.addEventListener("DOMContentLoaded", function () {
  // === Foto Preview ===
  const fotoInput = document.getElementById("foto");
  const previewFoto = document.getElementById("preview-foto");

  if (fotoInput && previewFoto) {
    fotoInput.addEventListener("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewFoto.src = e.target.result;
          previewFoto.style.display = "block";
        };
        reader.readAsDataURL(file);
      }
    });
  }

  // === Sidebar Toggle ===
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");

  if (sidebarToggle && sidebar) {
    const savedSidebarState =
      localStorage.getItem("sidebarState") || "expanded";

    // Set initial sidebar state
    if (savedSidebarState === "collapsed" && window.innerWidth > 992) {
      sidebar.classList.add("collapsed");
    }

    // Update icon based on state
    function updateSidebarIcon() {
      sidebarToggle.innerHTML = sidebar.classList.contains("collapsed")
        ? '<i class="fas fa-indent"></i>'
        : '<i class="fas fa-outdent"></i>';
    }
    updateSidebarIcon();

    sidebarToggle.addEventListener("click", () => {
      // Responsive behavior
      if (window.innerWidth <= 992) {
        sidebar.classList.remove("collapsed"); // Jangan collapsed di mobile
        sidebar.classList.toggle("active");
      } else {
        sidebar.classList.toggle("collapsed");
        const currentState = sidebar.classList.contains("collapsed")
          ? "collapsed"
          : "expanded";
        localStorage.setItem("sidebarState", currentState);
      }

      updateSidebarIcon();
    });

    window.addEventListener("resize", () => {
      if (window.innerWidth > 992) {
        sidebar.classList.remove("active");
      }
    });
  }

  // === Theme Toggle ===
  const themeToggle = document.getElementById("themeToggle");
  const html = document.documentElement;

  if (themeToggle) {
    const savedTheme =
      localStorage.getItem("theme") ||
      (window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light");

    html.setAttribute("data-theme", savedTheme);

    themeToggle.addEventListener("click", () => {
      const currentTheme = html.getAttribute("data-theme");
      const newTheme = currentTheme === "light" ? "dark" : "light";
      html.setAttribute("data-theme", newTheme);
      localStorage.setItem("theme", newTheme);
    });
  }

  
});
