<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dataterm Alpha</title>
  <style>
    /* Global resets and font choices */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      background-color: #f0e9d8; /* A warm off-white / beige */
      font-family: "Lucida Console", Monaco, monospace; /* Retro TUI feel */
      color: #333;
    }

    .interface {
      display: flex;
      flex-direction: column;
      max-width: 900px;
      margin: 1rem auto;
      padding: 1rem;
      border: 2px solid #222;
      background-color: #f7f2e4; /* Slightly different shade inside */
      position: relative;
    }

    /* Optional: light “noise” overlay to add a worn/retro texture */
    .interface::before {
      content: "";
      position: absolute;
      pointer-events: none;
      top: 0; left: 0; right: 0; bottom: 0;
      background: 
        radial-gradient(rgba(0,0,0,0.02) 2%, transparent 2%) 0 0/3px 3px repeat,
        linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px) repeat-x;
      opacity: 0.5;
      z-index: 10;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #222;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
    }
    .header-bar h1 {
      font-size: 1.5rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .status {
      background-color: #f9c74f; /* Amber highlight for the status box */
      padding: 0.25rem 0.5rem;
      border: 2px solid #222;
      font-weight: bold;
      text-transform: uppercase;
    }

    .main-panel {
      display: flex;
      gap: 1rem;
    }

    /* Left “Alpha” block */
    .alpha-block {
      flex: 1;
      border: 2px solid #222;
      padding: 1rem;
      background-color: #d98edd; /* Vibrant pink/purple from the screenshot */
      color: #000;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-transform: uppercase;
    }
    .alpha-block .large-number {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .alpha-block .alpha-text {
      font-size: 1.3rem;
      font-weight: 600;
    }

    /* Server Room block */
    .server-room {
      flex: 2;
      border: 2px solid #222;
      padding: 1rem;
      background-color: #fff;
    }
    .server-room h2 {
      margin-bottom: 1rem;
      text-transform: uppercase;
      border-bottom: 2px solid #222;
      display: inline-block;
      padding-bottom: 0.25rem;
      font-size: 1rem;
      letter-spacing: 1px;
    }
    .server-room .server-list {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }
    .server-icon {
      width: 60px;
      height: 80px;
      border: 2px solid #222;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: #ece8db;
      text-transform: uppercase;
      font-size: 0.7rem;
      font-weight: bold;
      cursor: default;
      position: relative;
    }
    .server-icon span {
      pointer-events: none;
    }

    /* Info panel text (TFTP, IP info, etc.) */
    .info-text {
      margin-top: 1rem;
      font-size: 0.8rem;
      line-height: 1.3;
      color: #555;
    }

    /* The big “Access Terminal” button */
    .controls {
      margin-top: 1rem;
      display: flex;
      gap: 1rem;
    }
    .btn {
      display: inline-block;
      border: 2px solid #222;
      background-color: #111;
      color: #fff;
      padding: 0.5rem 1rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      position: relative;
    }
    .btn:hover {
      background-color: #333;
    }
    .btn::after {
      /* Simulated “pointer” on the button, purely decorative */
      content: "►";
      position: absolute;
      right: 0.5rem;
      transform: translateY(-50%);
      top: 50%;
      font-size: 0.8rem;
    }

    /* Footer message (like the warp engine info) */
    .footer-console {
      margin-top: 2rem;
      font-size: 0.8rem;
      font-weight: bold;
      color: #222;
      border-top: 2px solid #222;
      padding-top: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="interface">
    <div class="header-bar">
      <h1>Dataterm ALPHA</h1>
      <div class="status">ONLINE</div>
    </div>

    <div class="main-panel">
      <!-- ALPHA block on the left -->
      <div class="alpha-block">
        <div class="large-number">1</div>
        <div class="alpha-text">ALPHA</div>
      </div>

      <!-- Server Room info block -->
      <div class="server-room">
        <h2>Server Room</h2>

        <div class="server-list">
          <!-- Basic server icons -->
          <div class="server-icon"><span>A_20</span></div>
          <div class="server-icon"><span>A_30</span></div>
          <div class="server-icon"><span>A_40</span></div>
          <div class="server-icon"><span>A_50</span></div>
          <div class="server-icon"><span>A_60</span></div>
        </div>

        <div class="info-text">
          Using LYNX_ETHERNET device<br/>
          TFTP from server 192.168.0.104; Our IP address is 192.168.0.105<br/>
          Filename 'boot.img'.
        </div>

        <div class="controls">
          <button class="btn">Access Terminal</button>
          <button class="btn">Gate Status</button>
        </div>
      </div>
    </div>

    <div class="footer-console">
      Warp Engine Sector Distance To Travel: 3<br/>
      Course (0-360): 40<br/>
      Enterprise in Quadrant – (3,4) Sector (3,2)
    </div>
  </div>
</body>
</html>
