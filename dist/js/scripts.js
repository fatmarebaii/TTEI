async function getDat() {
    const response = await fetch("http://192.168.201.19/TTEI/startbootstrap-heroic-features-master/php/index.php");
    const data = await response.json();
    document.getElementById("#date").innerHTML = "<h4>" + data.date + "</h4>";
  }
  getDat()

  function getDat() {
    fetch('http://192.168.201.19/TTEI/startbootstrap-heroic-features-master/php/index.php')
      .then(response => response.json())
      .then(data => {
        // Vérifiez si l'élément ciblé existe avant de lui affecter une valeur
        let element = document.querySelector('#date');
        if (element !== null) {
          element.innerHTML = data.date;
        }
      })
      .catch(error => console.error(error));
  }

  async function getTim() {
    const response = await fetch("http://192.168.201.19/TTEI/startbootstrap-heroic-features-master/php/index.php");
    const data = await response.json();
    document.getElementById("#time").innerHTML = "<h1>" + data.time + "</h1>";
  }
  getTim()

  function getTim() {
    fetch('http://192.168.201.19/TTEI/startbootstrap-heroic-features-master/php/index.php')
      .then(response => response.json())
      .then(data => {
        // Vérifiez si l'élément ciblé existe avant de lui affecter une valeur
        let element = document.querySelector('#time');
        if (element !== null) {
          element.innerHTML = data.time;
        }
      })
      .catch(error => console.error(error));
  }

