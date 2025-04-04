document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".pestaña");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => { 
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));  

        tab.classList.add("active");
        const tabId = tab.getAttribute("data-tab");
        document.getElementById(`tab-${tabId}`).classList.add("active");
      });
    });
  });