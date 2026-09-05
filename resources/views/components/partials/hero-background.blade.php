{{-- ============================================================
     Hero Animated Background (Full-Page)
     - Canvas-based: morphing blobs + mouse-trail syntax fragments
     - Covers entire viewport behind all page content
     - Reads data-theme from <html> for light/dark mode colors
     ============================================================ --}}

<style>
    /* Canvas fills the full viewport, fixed behind all content */
    .hero-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: -1;
        pointer-events: none;
    }
</style>

<canvas class="hero-canvas" id="heroBgCanvas" aria-hidden="true"></canvas>

<script>
(function () {
    'use strict';

    /* ==========================================================
       1. THEME DETECTION
       Reads data-theme attribute from <html> to pick colors.
       Re-checks on every frame so a live theme toggle works.
       ========================================================== */
    var THEMES = {
        dark: {
            blobs: [
                [111, 168, 78],            /* #6FA84E */
                [143, 191, 107],           /* #8FBF6B */
                [79, 138, 52]             /* #4F8A34 */
            ],
            blobAlpha: 0.32
        },
        light: {
            blobs: [
                [143, 191, 107],           /* #8FBF6B */
                [169, 208, 132],           /* #A9D084 */
                [111, 168, 78]            /* #6FA84E */
            ],
            blobAlpha: 0.35
        }
    };

    /* Syntax-highlighting palette (works on both themes) */
    var SYNTAX_COLORS = [
        '#7fe878',  /* keyword (accent green) */
        '#a78bfa',  /* string / number (purple) */
        '#f9a825',  /* operator (amber) */
        '#4fc3f7',  /* type / class (blue) */
        '#e57373',  /* constant / null (red) */
        '#81c784',  /* function (soft green) */
        '#ce93d8',  /* comment (pink) */
        '#ffcc80'   /* property (orange) */
    ];

    /* Tokens that appear near the cursor */
    var TOKENS = [
        'const', 'let', 'function', '=>', 'return',
        'SELECT', 'FROM', 'WHERE', 'JOIN',
        'null', 'true', 'false', 'undefined',
        'class', 'new', 'this', 'import',
        'async', 'await', 'try', 'catch',
        '$', '{}', '[]', '===', '!==',
        'if', 'else', 'for', 'while',
        'int', 'float', 'void', 'struct'
    ];

    function getTheme() {
        var name = document.documentElement.getAttribute('data-theme') || 'dark';
        return THEMES[name] || THEMES.dark;
    }

    /* ==========================================================
       2. SETUP — Canvas, resize handler, animation state
       ========================================================== */
    var canvas = document.getElementById('heroBgCanvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');

    var width = 0;
    var height = 0;
    var dpr = window.devicePixelRatio || 1;

    /* Mouse position relative to viewport (null = pointer not tracked) */
    var mouseX = null;
    var mouseY = null;

    /* Track whether user is on a touch device (no mouse trail) */
    var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    /* Resize canvas to match full viewport */
    function resize() {
        width  = window.innerWidth;
        height = window.innerHeight;
        canvas.width  = width * dpr;
        canvas.height = height * dpr;
        canvas.style.width  = width + 'px';
        canvas.style.height = height + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    window.addEventListener('resize', resize);
    resize();

    /* ==========================================================
       3. BLOB DEFINITION
       Three large soft circles that drift in slow sine/cosine
       loops. Each blob has its own speed, radius, and phase so
       they never sync up.
       ========================================================== */
    var blobs = [
        {
            /* Center X amplitude, center Y amplitude, base radius */
            ax: 0.25, ay: 0.18, r: 0.22,
            /* Speed (lower = slower), phase offset for x and y */
            sx: 0.15, sy: 0.12, px: 0,     py: 0
        },
        {
            ax: 0.20, ay: 0.25, r: 0.18,
            sx: 0.10, sy: 0.18, px: 2.1,   py: 1.3
        },
        {
            ax: 0.30, ay: 0.15, r: 0.16,
            sx: 0.18, sy: 0.08, px: 4.2,   py: 3.5
        }
    ];

    /**
     * Draw one blob as a radial gradient circle.
     * The gradient fades from the blob color at center to fully
     * transparent at the edge, giving a soft blurred look.
     *
     * @param {number} cx - Center X in pixels
     * @param {number} cy - Center Y in pixels
     * @param {number} radius - Blob radius in pixels
     * @param {Array}  color  - [r, g, b] array
     * @param {number} alpha  - Opacity (0-1)
     */
    function drawBlob(cx, cy, radius, color, alpha) {
        /* Create a radial gradient: opaque center -> transparent edge */
        var grad = ctx.createRadialGradient(cx, cy, 0, cx, cy, radius);
        grad.addColorStop(0,   'rgba(' + color[0] + ',' + color[1] + ',' + color[2] + ',' + alpha + ')');
        grad.addColorStop(0.5, 'rgba(' + color[0] + ',' + color[1] + ',' + color[2] + ',' + (alpha * 0.5) + ')');
        grad.addColorStop(1,   'rgba(' + color[0] + ',' + color[1] + ',' + color[2] + ',0)');

        ctx.fillStyle = grad;
        ctx.beginPath();
        ctx.arc(cx, cy, radius, 0, Math.PI * 2);
        ctx.fill();
    }

    /* ==========================================================
       4. MOUSE-TRAIL SYNTAX FRAGMENTS
       On mouse move over the page, spawn small text snippets
       (code keywords, operators, etc.) near the cursor. Each
       fragment drifts slightly upward and fades out over ~1s.
       ========================================================== */
    var fragments = [];          /* Active fragments on screen */
    var FRAGMENT_LIFETIME = 1000; /* milliseconds */
    var FRAGMENT_SPEED   = 0.3;  /* pixels per frame upward drift */
    var lastSpawnTime    = 0;
    var SPAWN_INTERVAL   = 60;   /* ms between spawns (throttle) */

    /**
     * Create a new syntax fragment at the given position.
     */
    function spawnFragment(x, y) {
        var text  = TOKENS[Math.floor(Math.random() * TOKENS.length)];
        var color = SYNTAX_COLORS[Math.floor(Math.random() * SYNTAX_COLORS.length)];

        /* Offset from cursor so text doesn't cover the pointer */
        var offsetX = (Math.random() - 0.5) * 80;
        var offsetY = (Math.random() - 0.5) * 40;

        fragments.push({
            x:      x + offsetX,
            y:      y + offsetY,
            text:   text,
            color:  color,
            birth:  performance.now(),
            /* Small random rotation for a natural feel */
            angle:  (Math.random() - 0.5) * 0.3,
            /* Font size varies slightly */
            size:   11 + Math.random() * 5
        });
    }

    /**
     * Update and draw all active fragments.
     * Removes fragments that have exceeded their lifetime.
     */
    function drawFragments(now) {
        var i = fragments.length;
        while (i--) {
            var f = fragments[i];
            var age = now - f.birth;

            /* Remove expired fragments */
            if (age > FRAGMENT_LIFETIME) {
                fragments.splice(i, 1);
                continue;
            }

            /* Fade: fully visible for first 60%, then linear fade */
            var life = age / FRAGMENT_LIFETIME;
            var alpha = life < 0.6 ? 1.0 : 1.0 - ((life - 0.6) / 0.4);

            /* Drift upward slowly */
            f.y -= FRAGMENT_SPEED;

            ctx.save();
            ctx.translate(f.x, f.y);
            ctx.rotate(f.angle);
            ctx.globalAlpha = alpha * 0.85;
            ctx.fillStyle = f.color;
            ctx.font = '600 ' + f.size + 'px "Sora", monospace';
            ctx.fillText(f.text, 0, 0);
            ctx.restore();
        }
    }

    /* ==========================================================
       5. MOUSE / TOUCH EVENT LISTENERS
       Track pointer position across the full viewport so the
       trail knows where to spawn fragments.
       ========================================================== */
    if (!isTouch) {
        /* Listen on document so fragments work across all sections */
        document.addEventListener('mousemove', function (e) {
            mouseX = e.clientX;
            mouseY = e.clientY;

            /* Throttle fragment spawning */
            var now = performance.now();
            if (now - lastSpawnTime > SPAWN_INTERVAL) {
                spawnFragment(mouseX, mouseY);
                lastSpawnTime = now;
            }
        });

        document.addEventListener('mouseleave', function () {
            mouseX = null;
            mouseY = null;
        });
    }

    /* ==========================================================
       6. MAIN ANIMATION LOOP
       Runs at 60fps via requestAnimationFrame. Each frame:
       a) Clears the canvas
       b) Reads current theme for colors
       c) Draws the 3 morphing blobs
       d) Draws / updates mouse-trail fragments
       ========================================================== */
    function animate(now) {
        requestAnimationFrame(animate);

        /* Clear the canvas completely each frame */
        ctx.clearRect(0, 0, width, height);

        var theme     = getTheme();
        var blobColors = theme.blobs;
        var blobAlpha  = theme.blobAlpha;

        /* ---- Draw blobs ---- */
        for (var i = 0; i < blobs.length; i++) {
            var b = blobs[i];

            /* Compute center position using sine / cosine.
               sin(time * speed + phase) gives a smooth back-and-forth
               value between -1 and 1. We map that to pixel coordinates. */
            var cx = width  * 0.5 + Math.sin(now * 0.001 * b.sx + b.px) * width  * b.ax;
            var cy = height * 0.5 + Math.cos(now * 0.001 * b.sy + b.py) * height * b.ay;

            /* Radius also pulses very slightly for a breathing feel */
            var pulseR = b.r + Math.sin(now * 0.0005 + b.px) * 0.02;
            var radius = Math.max(width, height) * pulseR;

            drawBlob(cx, cy, radius, blobColors[i], blobAlpha);
        }

        /* ---- Draw mouse-trail fragments ---- */
        if (!isTouch) {
            drawFragments(now);
        }
    }

    /* Kick off the animation */
    requestAnimationFrame(animate);

})();
</script>
