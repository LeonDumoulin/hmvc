class Chat {
    constructor(chatBoxParentID, textAreaID, sendBtnID) {
        this.chatBoxParentID = chatBoxParentID;
        this.textAreaID = textAreaID;
        this.sendBtnID = sendBtnID;
    }

    renderJSON(data){
        data.message = document.getElementById(this.textAreaID).value;
        data.message = data.message.split("\n")[0]
        return JSON.stringify(data);

    }

    sendHelper(socket, data){
        let message = document.getElementById(this.textAreaID).value;
        socket.send(this.renderJSON(data))
        document.getElementById(this.textAreaID).value = null;
        const chatBox = document.getElementById(this.chatBoxParentID);
        const msgComponent = this.msgInComponent(message);
        chatBox.appendChild(msgComponent)
    }


    renderViewIn(socket, data) {
        document.getElementById(this.textAreaID).addEventListener('keyup', event => {
            if (event.isComposing || event.keyCode == 13) {
               this.sendHelper(socket, data)
            }
        })
        const viewInBtn = document.getElementById(this.sendBtnID);
        viewInBtn.addEventListener('click', (event) => {
            this.sendHelper(socket, data)
        })
    }

    renderViewOut(msg) {

        const htmlText = `<div class="d-flex justify-content-start mb-10">
            <div class="d-flex flex-column align-items-start">
                <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">${msg}</div>
            </div>
        </div>`;

        const chatBox = document.getElementById(this.chatBoxParentID);
        const parser = new DOMParser();
        const parsedHtml = parser.parseFromString(htmlText, 'text/html').body.firstChild;
        chatBox.appendChild(parsedHtml)

    }

    msgInComponent(msg) {
        const htmlText = `<div class="d-flex justify-content-end mb-10">
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">${msg}</div>
                                    </div>
                                </div>
        `;

        const parser = new DOMParser();
        const parsedHtml = parser.parseFromString(htmlText, 'text/html');
        return parsedHtml.body.firstChild

    }
}



