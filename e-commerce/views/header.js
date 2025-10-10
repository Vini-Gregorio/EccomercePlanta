// Load server-rendered header (shows logged-in user when available)
fetch('header.php')
  .then(response => response.text())
  .then(data => {
    document.getElementById('main-header').innerHTML = data;
  })
  .catch(() => {
    // fallback to static header if PHP endpoint not available
    fetch('header.html')
      .then(r => r.text())
      .then(d => { document.getElementById('main-header').innerHTML = d; });
  });
