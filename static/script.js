function x(input) {
  input = btoa(input);
  input = input.split("");
  var length = input.length;
  var offset = length;
  let pairs = [];
  while (offset > 0) {
    var max = Math.min(8, offset);
    var rand = Math.floor(Math.random() * (max - 1 + 1) + 1);
    var string = "";
    for (let i = 0; i < rand; i++) {
      string += input[length - offset];
      offset -= 1;
    }
    pairs.push(string);
  }
  let encoded = pairs.reverse().join("?");
  document.getElementById("code-mail").innerText = encoded;
  document.getElementById("code-html").innerText = encoded;
}

document.getElementById("email").addEventListener("keyup", (event) => {
  x(event.target.value);
});
