const express = require("express");
const bodyParser = require("body-parser");
const fs = require("fs");
const axios = require("axios");
const shelljs = require("shelljs");

const config = require("./config.json");
const { Client, LocalAuth } = require("whatsapp-web.js");

process.title = "whatsapp-node-api";
// global.client;
// global.client2;
// global.authed = false;
// global.authed2 = false;


const app = express();

const port = process.env.PORT || config.port;
//Set Request Size Limit 50 MB
app.use(bodyParser.json({ limit: "50mb" }));

app.use(express.json());
app.use(bodyParser.urlencoded({ extended: true }));

global.users = [
  {
      "device_id":"12345",
      "phone" : "081953656221",
      "status" : "offline",
      "token" : "asasasasasas"
  },
  {
      "device_id":"678910",
      "phone" : "082134889246",
      "status" : "offline",
      "token" : "12121212121"
  }
];


function createWhatsAppClient(userData) {
  // console.log(deviceId);

  const client = new Client({
    authStrategy: new LocalAuth({
      clientId: userData.device_id,
    }),
    puppeteer: { headless: true },
  });


  client.on("qr", (qr) => {
    console.log("qr");
    fs.writeFileSync(`./components/last_${userData.device_id}.qr`, qr);
  });

  
  client.on("authenticated", () => {
    console.log("AUTH!");
    try {
      fs.unlinkSync("./components/last_"+userData.device_id+".qr");
    } catch (err) {}
  });
  
  client.on("auth_failure", () => {
    console.log("AUTH Failed !");
    process.exit();
  });
  
  client.on("ready", () => {
    console.log("Client is ready!");
  });
  
  client.on("message", async (msg) => {
    if (config.webhook.enabled) {
      if (msg.hasMedia) {
        const attachmentData = await msg.downloadMedia();
        msg.attachmentData = attachmentData;
      }
      axios.post(config.webhook.path, { msg });
    }
    if(msg.body === '!ping') {
      msg.reply('pong');
    }
  });
  client.on("disconnected", () => {
    console.log("disconnected");
  });
  // client.initialize();
  return client;
}

global.clients = [];

for (const userData of users) {
  const client = createWhatsAppClient(userData);
  clients.push({
    "device_id":userData.device_id,
    "client": client
  });
}

for (let index = 0; index < clients.length; index++) {
  const client = clients[index];
  console.log("running initialize");
  client.client.initialize();
}


/* startSessionByDeciveId = async (deviceId) => {
  console.log(deviceId);

  client = new Client({
    authStrategy: new LocalAuth({
      clientId: deviceId,
    }),
    puppeteer: { headless: true },
  });
  
  authed = false;

  client.on("qr", (qr) => {
    console.log("qr");
    fs.writeFileSync("./components/last.qr", qr);
  });
  
  client.on("authenticated", () => {
    console.log("AUTH!");
    authed = true;
  
    try {
      fs.unlinkSync("./components/last.qr");
    } catch (err) {}
  });
  
  client.on("auth_failure", () => {
    console.log("AUTH Failed !");
    process.exit();
  });
  
  client.on("ready", () => {
    console.log("Client is ready!");
  });
  
  client.on("message", async (msg) => {
    if (config.webhook.enabled) {
      if (msg.hasMedia) {
        const attachmentData = await msg.downloadMedia();
        msg.attachmentData = attachmentData;
      }
      axios.post(config.webhook.path, { msg });
    }
  });
  client.on("disconnected", () => {
    console.log("disconnected");
  });
  client.initialize();
} */

/* startSessionByDeciveId2 = async (deviceId) => {
  console.log(deviceId);

  client2 = new Client({
    authStrategy: new LocalAuth({
      clientId: deviceId,
    }),
    puppeteer: { headless: true },
  });
  
  authed2 = false;

  client2.on("qr", (qr) => {
    console.log("qr");
    fs.writeFileSync("./components/last.qr", qr);
  });
  
  client2.on("authenticated", () => {
    console.log("AUTH!");
    authed2 = true;
  
    try {
      fs.unlinkSync("./components/last.qr");
    } catch (err) {}
  });
  
  client2.on("auth_failure", () => {
    console.log("AUTH Failed !");
    process.exit();
  });
  
  client2.on("ready", () => {
    console.log("Client is ready!");
  });
  
  client2.on("message", async (msg) => {
    if (config.webhook.enabled) {
      if (msg.hasMedia) {
        const attachmentData = await msg.downloadMedia();
        msg.attachmentData = attachmentData;
      }
      axios.post(config.webhook.path, { msg });
    }
  });
  client2.on("disconnected", () => {
    console.log("disconnected");
  });
  client2.initialize();
} */

// startSessionByDeciveId('12345');
// startSessionByDeciveId2('678910');

const chatRoute = require("./components/chatting");
const groupRoute = require("./components/group");
const authRoute = require("./components/auth");
const contactRoute = require("./components/contact");

app.use(function (req, res, next) {
  console.log(req.method + " : " + req.path);
  next();
});
app.use("/chat", chatRoute);
app.use("/group", groupRoute);
app.use("/auth", authRoute);
app.use("/contact", contactRoute);

app.listen(port, () => {
  console.log("Server Running Live on Port : " + port);
});
