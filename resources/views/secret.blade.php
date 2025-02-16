<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fireflies with Mouse Ripples & Transition</title>
    <!-- Load three.js dan GLTFLoader -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <style>
      /* Basic styling untuk body dan canvas */
      body {
        margin: 0;
        overflow: hidden;
        background-color: #000;
      }
      canvas {
        display: block;
      }
      /* Iframe full-screen untuk menampilkan game */
      #game-iframe {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        display: none;
        z-index: 9999;
      }
      /* Styling tombol "Go Find The Cat" */
      #change-btn,
      /* Styling tombol "Back" */
      #back-btn {
        position: fixed;
        bottom: 20px;
        padding: 15px 30px;
        font-size: 1.2em;
        background: linear-gradient(45deg, #ff416c, #ff4b2b);
        border: none;
        border-radius: 8px;
        color: #fff;
        cursor: pointer;
        z-index: 10000;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      /* Posisi tombol "Go Find The Cat" di pojok kanan bawah */
      #change-btn {
        right: 20px;
      }
      /* Posisi tombol "Back" di pojok kiri bawah */
      #back-btn {
        left: 20px;
      }
      #change-btn:hover,
      #back-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
      }
      #change-btn:active,
      #back-btn:active {
        transform: scale(0.98);
      }
      /* Sembunyikan tombol secara default */
      #change-btn,
      #back-btn {
        display: none;
      }
    </style>
  </head>
  <body>
    <!-- Canvas untuk three.js -->
    <canvas id="webgl-canvas"></canvas>
    <!-- Iframe full-screen untuk menampilkan game -->
    <iframe id="game-iframe"></iframe>
    <!-- Tombol untuk beralih ke website oiiaioiiiai ("Go Find The Cat") -->
    <button id="change-btn">Go Find The Cat</button>
    <!-- Tombol untuk kembali ke game Dino Fiqri -->
    <button id="back-btn">Back</button>

    <script>
      /************** Setup: Scene, Renderer, dan Camera **************/
      const scene = new THREE.Scene();
      const canvas = document.getElementById("webgl-canvas");
      const renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true });
      renderer.setSize(window.innerWidth, window.innerHeight);
      
      // Frustum dinamis untuk orthographic camera
      let aspectRatio = window.innerWidth / window.innerHeight;
      let frustumHeight = window.innerHeight / 100;
      let frustumWidth = frustumHeight * aspectRatio;
      const camera = new THREE.OrthographicCamera(
        -frustumWidth / 2,
        frustumWidth / 2,
        frustumHeight / 2,
        -frustumHeight / 2,
        0.1,
        1000
      );
      camera.position.set(0, 0, 50);
      camera.lookAt(0, 0, 0);
      
      /************** Variabel Global untuk Animasi dan Transisi **************/
      let threejsActive = true; // Digunakan untuk menghentikan loop three.js ketika transisi terjadi
      let daskomModel = null;   // Untuk menyimpan model 3D logo daskom
      const daskomClock = new THREE.Clock(); // Untuk animasi model

      // Untuk raycasting (mendeteksi klik pada model)
      const raycaster = new THREE.Raycaster();
      const mouse = new THREE.Vector2();

      /************** Background Setup **************/
      const backgroundTexture = new THREE.TextureLoader().load("/assets/Background 1.webp");
      const backgroundGeometry = new THREE.PlaneGeometry(frustumWidth, frustumHeight);
      const backgroundMaterial = new THREE.MeshStandardMaterial({
        map: backgroundTexture,
        side: THREE.DoubleSide,
        metalness: 0.5,
        roughness: 0.5
      });
      const background = new THREE.Mesh(backgroundGeometry, backgroundMaterial);
      background.position.set(0, 0, -5);
      scene.add(background);

      /************** GLTF Model Loader untuk 3D Logo **************/
      const loader = new THREE.GLTFLoader();
      loader.load(
        "/assets/daskom.glb",
        function (gltf) {
          daskomModel = gltf.scene;
          scene.add(daskomModel);
          // Atur posisi, rotasi, dan skala model
          daskomModel.position.set(0, 0, -3.5);
          daskomModel.rotation.x = (Math.PI / 2) * 0.9;
          daskomModel.scale.set(0.3, 0.3, 0.3);
        },
        undefined,
        function (error) {
          console.error("Terjadi kesalahan saat memuat model:", error);
        }
      );

      /************** Ambient Light **************/
      const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
      scene.add(ambientLight);

      /************** Firefly Setup **************/
      const fireflyCount = 10;
      const fireflies = [];
      const fireflyRangeX = frustumWidth;
      const fireflyRangeY = frustumHeight;
      const fireflyRangeZ = -4;
      for (let i = 0; i < fireflyCount; i++) {
        const color = new THREE.Color().setHSL(Math.random() * 0.1 + 0.6, 1, 1);
        const light = new THREE.PointLight(color, 1.5, 5);
        light.position.set(
          (Math.random() - 0.5) * fireflyRangeX,
          (Math.random() - 0.5) * fireflyRangeY,
          fireflyRangeZ
        );
        fireflies.push({
          light: light,
          velocity: new THREE.Vector3(
            (Math.random() - 0.5) * 0.05,
            (Math.random() - 0.5) * 0.05,
            (Math.random() - 0.5) * 0.05
          )
        });
        scene.add(light);
      }

      /************** Sistem Ripple Mouse (Tetap sama) **************/
      let ripples = [];
      const maxRipples = 4;
      let lastMousePosition = null;
      function createRipple(x, y) {
        let force = 0;
        let vx = 0;
        let vy = 0;
        if (lastMousePosition) {
          const relativeX = x - lastMousePosition.x;
          const relativeY = y - lastMousePosition.y;
          const distanceSquared = relativeX * relativeX + relativeY * relativeY;
          const distance = Math.sqrt(distanceSquared);
          if (distance > 0) {
            vx = relativeX / distance;
            vy = relativeY / distance;
            force = Math.min(distanceSquared * 10000, 1);
          }
        }
        lastMousePosition = { x, y };
        const lightBg = new THREE.PointLight(0xffffff, 3, 3);
        lightBg.position.set(x, y, -3);
        const rippleBg = {
          light: lightBg,
          age: 0,
          maxAge: 16,
          force,
          vx,
          vy,
          initialIntensity: 4
        };
        scene.add(lightBg);
        ripples.push(rippleBg);
        if (ripples.length > maxRipples) {
          const oldRipple = ripples.shift();
          scene.remove(oldRipple.light);
        }
      }
      function updateRipples() {
        const agePart = 1.0 / maxRipples;
        for (let i = ripples.length - 1; i >= 0; i--) {
          const ripple = ripples[i];
          const slowAsOlder = 1.0 - ripple.age / ripple.maxAge;
          const force = ripple.force * agePart * slowAsOlder;
          ripple.light.position.x += ripple.vx * force;
          ripple.light.position.y += ripple.vy * force;
          ripple.age += 1;
          let intensity;
          if (ripple.age < ripple.maxAge * 0.3) {
            intensity = Math.sin((ripple.age / (ripple.maxAge * 0.3)) * (Math.PI / 2));
          } else {
            const t = 1 - (ripple.age - ripple.maxAge * 0.3) / (ripple.maxAge * 0.7);
            intensity = -t * (t - 2);
          }
          intensity *= ripple.force;
          ripple.light.intensity = intensity * ripple.initialIntensity;
          if (ripple.age > ripple.maxAge) {
            scene.remove(ripple.light);
            ripples.splice(i, 1);
          }
        }
      }
      window.addEventListener("mousemove", function (event) {
        const x = (event.clientX / window.innerWidth) * frustumWidth - frustumWidth / 2;
        const y = -(event.clientY / window.innerHeight) * frustumHeight + frustumHeight / 2;
        createRipple(x, y);
      });

      /************** Loop Animasi Utama **************/
      function animate() {
        if (!threejsActive) return; // Hentikan loop jika three.js telah dihentikan
        requestAnimationFrame(animate);
        const elapsedTime = daskomClock.getElapsedTime();
        if (daskomModel) {
          // Animasi osilasi dan rotasi pada model daskom
          daskomModel.position.y = Math.sin(elapsedTime * 2) * 0.2;
          daskomModel.rotation.z += 0.02;
        }
        // Update posisi fireflies dan pantulkan jika melebihi batas
        fireflies.forEach(({ light, velocity }) => {
          light.position.add(velocity);
          if (Math.abs(light.position.x) > fireflyRangeX / 2) velocity.x *= -1;
          if (Math.abs(light.position.y) > fireflyRangeY / 2) velocity.y *= -1;
          if (Math.abs(light.position.z) > Math.abs(fireflyRangeZ) / 2) velocity.z *= -1;
        });
        updateRipples();
        renderer.render(scene, camera);
      }
      animate();

      /************** Raycasting untuk Klik pada 3D Logo **************/
      canvas.addEventListener("click", function (event) {
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        raycaster.setFromCamera(mouse, camera);
        if (daskomModel) {
          const intersects = raycaster.intersectObject(daskomModel, true);
          if (intersects.length > 0) {
            startGameTransition();
          }
        }
      });

      /************** Fungsi Transisi **************/
      function startGameTransition() {
        // Hentikan animasi three.js dan sembunyikan canvas
        threejsActive = false;
        canvas.style.display = "none";
        // Tampilkan iframe full-screen dengan game Dino Fiqri
        const gameIframe = document.getElementById("game-iframe");
        gameIframe.src = "https://kryptonite.tatsuyaryu.my.id/";
        gameIframe.style.display = "block";
        // Setelah 30 detik, tampilkan tombol "Go Find The Cat"
        setTimeout(() => {
          document.getElementById("change-btn").style.display = "block";
        }, 30000);
      }

      /************** Tombol "Go Find The Cat" dan "Back" **************/
      // Tombol "Go Find The Cat" mengubah iframe ke website oiiaioiiiai
      const changeBtn = document.getElementById("change-btn");
      changeBtn.addEventListener("click", function () {
        const gameIframe = document.getElementById("game-iframe");
        gameIframe.src = "https://mhafiz03.github.io/oiiaioiiiai/";
        // Sembunyikan tombol ini dan tampilkan tombol "Back"
        changeBtn.style.display = "none";
        document.getElementById("back-btn").style.display = "block";
      });
      // Tombol "Back" mengembalikan iframe ke game Dino Fiqri
      const backBtn = document.getElementById("back-btn");
      backBtn.addEventListener("click", function () {
        const gameIframe = document.getElementById("game-iframe");
        gameIframe.src = "https://kryptonite.tatsuyaryu.my.id/";
        // Sembunyikan tombol "Back" dan tampilkan tombol "Go Find The Cat"
        backBtn.style.display = "none";
        changeBtn.style.display = "block";
      });

      /************** Handler Resize **************/
      window.addEventListener("resize", () => {
        const aspect = window.innerWidth / window.innerHeight;
        frustumHeight = window.innerHeight / 100;
        frustumWidth = frustumHeight * aspect;
        camera.left = -frustumWidth / 2;
        camera.right = frustumWidth / 2;
        camera.top = frustumHeight / 2;
        camera.bottom = -frustumHeight / 2;
        camera.updateProjectionMatrix();
        background.scale.set(frustumWidth, frustumHeight, 1);
        renderer.setSize(window.innerWidth, window.innerHeight);
      });
    </script>
  </body>
</html>
