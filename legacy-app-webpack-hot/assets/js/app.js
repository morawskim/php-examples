if (module.hot) {
  module.hot.accept();
}

import '../css/style.css';

document.getElementById('btn').addEventListener('click', function () {
    alert("Klik");
});
