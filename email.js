const form = document.querySelector("#contactForm");
const nameInput = document.querySelector('input[type="text"]');
const emailInput = document.querySelector('input[type="email"]');

form.addEventListener("submit", (event) => {
  event.preventDefault();
  const data = { name: nameInput.value, email: emailInput.value };
  // Create an XMLHttpRequest object
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    //Call a function when the state changes.
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      alert(xhttp.responseText);
    }
  };

  // Send a request
  xhttp.open("POST", "mail.php", true);
  //Send the proper header information along with the request
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
});
