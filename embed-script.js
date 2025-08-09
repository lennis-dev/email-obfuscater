class EmailObfuscator extends HTMLElement {
  static observedAttributes = ["obfuscated"];

  constructor() {
    super();
  }

  // Called whenever an observed attribute changes
  attributeChangedCallback(name, oldValue, newValue) {
    if (name === "obfuscated" && newValue) {
      this.renderEmail(newValue);
    }
  }

  renderEmail(encodedEmail) {
    this.innerHTML = ""; // Clear the current content

    // Decode the email from base64
    const a = atob(encodedEmail.split("?").reverse().join("")),
      b = document.createElement("a");
    b.innerText = a;
    b.href = "mailto:" + a;
    // Append the anchor to this custom element
    this.appendChild(b);
  }
}

// Define the custom element
customElements.define("obfuscated-email", EmailObfuscator);
