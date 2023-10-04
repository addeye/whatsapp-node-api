const router = require("express").Router();
const fs = require("fs");

router.get("/checkauth/:deviceId", async (req, res) => {
  const deviceId = req.params.deviceId;
  console.log(deviceId);
  if(deviceId == '12345'){
    client
    .getState()
    .then((data) => {
      console.log(data);
      res.send(data);
    })
    .catch((err) => {
      if (err) {
        res.send("DISCONNECTED");
      }
    });
  }else{
    client2
    .getState()
    .then((data) => {
      console.log(data);
      res.send(data);
    })
    .catch((err) => {
      if (err) {
        res.send("DISCONNECTED");
      }
    });
  }
  
});

router.get("/getqr/:token", async (req, res) => {
  const token = req.params.token;
  console.log(token);

  const device_id = users.find((user) => user.token == token).device_id;

    // const client = clients.find((client) => client._config.authStrategy.options.clientId === token);
  const client = clients.find((client) => client.device_id === device_id).client;

  client
    .getState()
    .then((data) => {
      if (data) {
        res.write("<html><body><h2>Already Authenticated</h2></body></html>");
        res.end();
      } else sendQr(res,device_id);
    })
    .catch(() => sendQr(res,device_id));
});

function sendQr(res,device_id) {
  fs.readFile("components/last_"+device_id+".qr", (err, last_qr) => {
    if (!err && last_qr) {
      var page = `
                    <html>
                        <body>
                            <script type="module">
                            </script>
                            <div id="qrcode"></div>
                            <script type="module">
                                import QrCreator from "https://cdn.jsdelivr.net/npm/qr-creator/dist/qr-creator.es6.min.js";
                                let container = document.getElementById("qrcode");
                                QrCreator.render({
                                    text: "${last_qr}",
                                    radius: 0.5, // 0.0 to 0.5
                                    ecLevel: "H", // L, M, Q, H
                                    fill: "#536DFE", // foreground color
                                    background: null, // color or null for transparent
                                    size: 256, // in pixels
                                }, container);
                            </script>
                        </body>
                    </html>
                `;
      res.write(page);
      res.end();
    }
  });
}

module.exports = router;
