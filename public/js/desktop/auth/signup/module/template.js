function getMessageSendEmail(email) {
    const template = `<h2>Signup email</h2>
    <div id="message-box">
        <div class="alert alert-success" role="alert">
            <p class="message-template">Una mail è stata inviata al tuo indirizzo email ${email}</p>
        </div>
    </div>`;
    document.querySelector('#message-container').innerHTML = template;
}


export { getMessageSendEmail }