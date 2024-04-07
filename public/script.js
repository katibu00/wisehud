const form = document.querySelector("form");
const chatContainer = document.querySelector("#chat_container");

let loadInterval;

function loader(element) {
    element.textContent = "";

    loadInterval = setInterval(() => {
        element.textContent += ".";

        if (element.textContent === "....") {
            element.textContent = "";
        }
    }, 300);
}

function typeText(element, text) {
    if (!text || typeof text !== "string") {
        // Handle the case when 'text' is not defined or not a string
        console.error("Invalid text value:", text);
        return;
    }

    let index = 0;

    let interval = setInterval(() => {
        if (index < text.length) {
            element.innerHTML += text.charAt(index);
            index++;
        } else {
            clearInterval(interval);
        }
    }, 20);
}

function generateUniqueId() {
    const timestamp = Date.now();
    const randomNumber = Math.random();
    const hexadecimalString = randomNumber.toString(16);

    return `id-${timestamp}-${hexadecimalString}`;
}


function chatStripe(isAi, value, uniqueId) {
    const textColor = isAi ? 'white' : 'black';
    const copyButtonStyles = isAi ? 'style="color: white;"' : '';

    return `
        <div class="wrapper ${isAi && "ai"}">
            <div class="chat">
                <div class="profile">
                    <img 
                        src="${isAi ? "/assets/bot.svg" : "/assets/user.svg"}"
                        alt="${isAi ? "bot" : "user"}"
                    />
                </div>
                <div class="message" id="${uniqueId}" style="color: ${textColor};">${value}</div>
                ${isAi ? `<button class="copy-btn" data-message-id="${uniqueId}" ${copyButtonStyles}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-check-fill" viewBox="0 0 16 16"><path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"/></svg></button>` : ''}
            </div>
        </div>
    `;
}



function copyMessageToClipboard(messageId) {
    const messageDiv = document.getElementById(messageId);
    const textArea = document.createElement("textarea");
    textArea.value = messageDiv.innerText;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);
    Swal.fire({
        icon: "success",
        title: "Copied!",
        text: "The message has been copied to the clipboard.",
        timerProgressBar: true,
        timer: 2000,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
        onClose: () => {
            Swal.hideLoading();
        }
    });

}

document.addEventListener("click", (e) => {
    const copyButton = e.target.closest(".copy-btn");
    if (copyButton) {
        const messageId = copyButton.getAttribute("data-message-id");
        copyMessageToClipboard(messageId);
    }
});




const handleSubmit = async (e) => {
    e.preventDefault();

    const data = new FormData(form);

    const textarea = form.querySelector("textarea");
    const submitButton = form.querySelector("#submit-button");
    const sendIcon = form.querySelector("#send-icon");
    const spinnerIcon = form.querySelector("#spinner-icon");

    // Disable textarea and change submit button icon to spinner
    textarea.disabled = true;
    submitButton.disabled = true;
    sendIcon.style.display = "none";
    spinnerIcon.style.display = "block";

    // users chatstripe
    chatContainer.innerHTML += chatStripe(false, data.get("prompt"));

    form.reset();

    // bots chatstripe
    const uniqueId = generateUniqueId();
    chatContainer.innerHTML += chatStripe(true, " ", uniqueId);

    chatContainer.scrollTop = chatContainer.scrollHeight;

    const messageDiv = document.getElementById(uniqueId);
    loader(messageDiv);

    const scrollDistance = chatContainer.scrollHeight - chatContainer.clientHeight;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const headers = new Headers();
    headers.append("X-CSRF-TOKEN", csrfToken);

    // Fetch conversation history from storage
    const conversationHistory = JSON.parse(localStorage.getItem("conversationHistory")) || [];

    // Add current message to conversation history
    conversationHistory.push({ role: "user", content: data.get("prompt") });

    fetch("/api/submit", {
        method: "POST",
        headers: headers,
        body: JSON.stringify({ prompt: data.get("prompt"), conversationHistory }), // Pass conversation history to the API
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.completion);

            clearInterval(loadInterval);
            messageDiv.innerHTML = " ";

            if (data.completion) {
                typeText(messageDiv, data.completion);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Insufficient Funds",
                    text: "Please fund your wallet to continue.",
                });
            }

            textarea.disabled = false;
            submitButton.disabled = false;
            sendIcon.style.display = "block";
            spinnerIcon.style.display = "none";

            chatContainer.scrollTop = scrollDistance;

            // Update conversation history with bot's response
            conversationHistory.push({ role: "bot", content: data.completion });
            localStorage.setItem("conversationHistory", JSON.stringify(conversationHistory));
        })
        .catch((error) => {
            console.error(error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "An error occurred. Please try again.",
            });
        });
};




form.addEventListener("submit", handleSubmit);

form.addEventListener("keyup", (e) => {
    if (e.keyCode === 13) {
        handleSubmit(e);
    }
});
