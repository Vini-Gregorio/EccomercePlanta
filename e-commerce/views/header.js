fetch('header.html')
  .then(response => response.text())
  .then(data => {
    document.getElementById('main-header').innerHTML = data;
  });
