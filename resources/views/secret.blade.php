<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fireflies with Mouse Ripples</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-color: #000;
        }
        canvas {
            display: block;
        }
    </style>
</head>
<body>
    <canvas id="webgl-canvas"></canvas>
    <script>
        // Scene, Renderer setup
        const scene = new THREE.Scene();
        const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('webgl-canvas'), antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // Dynamic frustum setup
        const aspectRatio = window.innerWidth / window.innerHeight;
        const frustumHeight = window.innerHeight / 100;
        const frustumWidth = frustumHeight * aspectRatio;

        // Orthographic Camera
        const camera = new THREE.OrthographicCamera(
            -frustumWidth / 2, frustumWidth / 2,
            frustumHeight / 2, -frustumHeight / 2,
            0.1, 1000
        );
        camera.position.set(0, 0, 50);
        camera.lookAt(0, 0, 0);

        // Background setup
        const backgroundTexture = new THREE.TextureLoader().load('/assets/Background 1.webp');
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

        const loader = new THREE.GLTFLoader();
        loader.load('/assets/daskom.glb', 
            function (gltf) {
                scene.add(gltf.scene);

                gltf.scene.position.set(0, 0, -3.5);
                gltf.scene.rotation.x = Math.PI / 2 * 0.9;
                gltf.scene.scale.set(0.3, 0.3, 0.3);

                 // Add oscillation and rotation in the animation loop
                const clock = new THREE.Clock(); // For timing
                function animate() {
                    requestAnimationFrame(animate);

                    const elapsedTime = clock.getElapsedTime();

                    // Oscillate up and down using sine wave
                    gltf.scene.position.y = Math.sin(elapsedTime * 2) * 0.2; // Frequency and amplitude
                    gltf.scene.rotation.z += 0.02; // Continuous rotation

                    // Render the scene
                    renderer.render(scene, camera);
                }

                animate(); // Start animation loop
            },
            undefined,
            function (error) {
                console.error('An error occurred:', error);
            }
        );

        // Ambient light
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
        scene.add(ambientLight);

        // Firefly setup
        const fireflyCount = 10;
        const fireflies = [];
        const fireflyRangeX = frustumWidth;
        const fireflyRangeY = frustumHeight;
        const fireflyRangeZ = -4;

        // Create fireflies
        for (let i = 0; i < fireflyCount; i++) {
            const color = new THREE.Color().setHSL(
                Math.random() * 0.1 + 0.6,
                1,
                1
            );
            const light = new THREE.PointLight(color, 1.5, 5);
            light.position.set(
                (Math.random() - 0.5) * fireflyRangeX,
                (Math.random() - 0.5) * fireflyRangeY,
                fireflyRangeZ
            );
            fireflies.push({
                light,
                velocity: new THREE.Vector3(
                    (Math.random() - 0.5) * 0.05,
                    (Math.random() - 0.5) * 0.05,
                    (Math.random() - 0.5) * 0.05
                )
            });
            scene.add(light);
        }

        // Ripple system setup
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

            // const light = new THREE.PointLight(0xffffff, 5, 5);
            const lightBg = new THREE.PointLight(0xffffff, 3, 3);
            // light.position.set(x, y, 0.5);
            lightBg.position.set(x, y, -3);
            
            // const ripple = {
            //     light,
            //     age: 0,
            //     maxAge: 4,
            //     force,
            //     vx,
            //     vy,
            //     initialIntensity: 2
            // };

            const rippleBg = {
                light: lightBg,
                age: 0,
                maxAge: 16,
                force,
                vx,
                vy,
                initialIntensity: 4
            };

            // scene.add(light);
            scene.add(lightBg);
            // ripples.push(ripple);
            ripples.push(rippleBg);

            if (ripples.length > maxRipples) {
                const oldRipple = ripples.shift();
                scene.remove(oldRipple.light);
            }
        }

        function updateRipples() {
            const agePart = 1.0 / maxRipples;

            ripples.forEach((ripple, index) => {
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
                    ripples.splice(index, 1);
                }
            });
        }

        // Mouse movement handler
        function onMouseMove(event) {
            const x = (event.clientX / window.innerWidth * frustumWidth) - (frustumWidth / 2);
            const y = -(event.clientY / window.innerHeight * frustumHeight) + (frustumHeight / 2);
            createRipple(x, y);
        }

        window.addEventListener('mousemove', onMouseMove);

        // Animation loop
        function animate() {
            requestAnimationFrame(animate);

            // Update fireflies
            fireflies.forEach(({ light, velocity }) => {
                light.position.add(velocity);

                if (Math.abs(light.position.x) > fireflyRangeX / 2) velocity.x *= -1;
                if (Math.abs(light.position.y) > fireflyRangeY / 2) velocity.y *= -1;
                if (Math.abs(light.position.z) > fireflyRangeZ / 2) velocity.z *= -1;
            });

            // Update ripples
            updateRipples();

            renderer.render(scene, camera);
        }

        animate();

        // Resize handler
        window.addEventListener('resize', () => {
            const aspect = window.innerWidth / window.innerHeight;
            const frustumHeight = window.innerHeight / 100;
            const frustumWidth = frustumHeight * aspect;

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