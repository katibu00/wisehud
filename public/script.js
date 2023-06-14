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
    return `
        <div class="wrapper ${isAi && "ai"}">
            <div class="chat">
                <div class="profile">
                    <img 
                        src="${isAi ? "/assets/bot.svg" : "/assets/user.svg"}"
                        alt="${isAi ? "bot" : "user"}"
                        />
                    </div>
                    <div class="message" id="${uniqueId}">${value}</div>
                </div>
            </div>
        </div>
        `;
}

const handleSubmit = async (e) => {
    e.preventDefault();

    const data = new FormData(form);

    // users chatstripe
    chatContainer.innerHTML += chatStripe(false, data.get("prompt"));

    form.reset();

    // bots chatstripe
    const uniqueId = generateUniqueId();
    chatContainer.innerHTML += chatStripe(true, " ", uniqueId);

    chatContainer.scrollTop = chatContainer.scrollHeight;

    const messageDIv = document.getElementById(uniqueId);
    loader(messageDIv);


    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const headers = new Headers();
    headers.append('X-CSRF-TOKEN', csrfToken);

    fetch('/api/submit', {
      method: 'POST',
      headers: headers,
      body: data
    })
    .then(response => response.json())
    .then(data => {
      console.log(data.message);

        clearInterval(loadInterval);
        messageDIv.innerHTML = " ";

        typeText(messageDIv, data.completion);
    })
    .catch(error => {
      console.error(error);
    });

};

form.addEventListener("submit", handleSubmit);

form.addEventListener("keyup", (e) => {
    if (e.keyCode === 13) {
        handleSubmit(e);
    }
});
