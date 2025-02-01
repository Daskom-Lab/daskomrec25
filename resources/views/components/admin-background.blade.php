<!-- Include Three.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<style>
    /* Ensure canvas covers the entire background */
    #webgl-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        /* Send canvas to the background */
    }
</style>
<!-- Three.js Background Script -->
<script>
    // Scene, Renderer setup
    const scene = new THREE.Scene();
    const renderer = new THREE.WebGLRenderer({
        canvas: document.getElementById('webgl-canvas'),
        antialias: true
    });
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

    // Firefly setup
    const fireflyCount = 20;
    const fireflies = [];
    const fireflyRangeX = frustumWidth;
    const fireflyRangeY = frustumHeight;
    const fireflyRangeZ = -4.4;

    // Create fireflies
    for (let i = 0; i < fireflyCount; i++) {
        const color = new THREE.Color().setHSL(
            Math.random() * 0.1 + 0.6,
            1,
            1
        );
        const light = new THREE.PointLight(color, 2, 12);
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
    const maxRipples = 5;
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

        lastMousePosition = {
            x,
            y
        };


        const lightBg = new THREE.PointLight(0xffffff, 1, 2);
        lightBg.position.set(x, y, -4.5);

        const rippleBg = {
            light: lightBg,
            age: 0,
            maxAge: 16,
            force,
            vx,
            vy,
            initialIntensity: 2
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
        fireflies.forEach(({
            light,
            velocity
        }) => {
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