  // Cubic Bezier function with parameters: (0.075, 0.82, 0.165, 1)
  // This function returns the eased value for a given time progress t (0 ≤ t ≤ 1)
  function cubicBezier(t, x1, y1, x2, y2) {
    // Pre-calculate coefficients
    var cx = 3 * x1;
    var bx = 3 * (x2 - x1) - cx;
    var ax = 1 - cx - bx;

    var cy = 3 * y1;
    var by = 3 * (y2 - y1) - cy;
    var ay = 1 - cy - by;

    // Functions to sample the Bezier curve for x and y at time t
    function sampleCurveX(t) {
      return ((ax * t + bx) * t + cx) * t;
    }
    function sampleCurveY(t) {
      return ((ay * t + by) * t + cy) * t;
    }
    // Given an x value (which is our progress t), use Newton's method to find the corresponding t on the curve.
    var epsilon = 1e-5;
    var t2 = t;
    for (var i = 0; i < 10; i++) {
      var x = sampleCurveX(t2) - t;
      if (Math.abs(x) < epsilon) break;
      var d = (3 * ax * t2 * t2 + 2 * bx * t2 + cx);
      if (d === 0) break;
      t2 = t2 - x / d;
    }
    return sampleCurveY(t2);
  }

  // Smooth scrolling function using our custom easing
  function smoothScrollTo(target, duration) {
    var startY = window.pageYOffset;
    var targetY = target.getBoundingClientRect().top;
    var startTime = null;

    function animation(currentTime) {
      if (!startTime) {
        startTime = currentTime;
      }
      var timeElapsed = currentTime - startTime;
      var progress = Math.min(timeElapsed / duration, 1);
      var easedProgress = cubicBezier(progress, 0.075, 0.82, 0.165, 1);
      window.scrollTo(0, startY + targetY * easedProgress);
      if (timeElapsed < duration) {
        requestAnimationFrame(animation);
      }
    }
    requestAnimationFrame(animation);
  }

  // Add smooth scrolling behavior to all anchor links that reference an ID on the page
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener("click", function(e) {
      e.preventDefault();
      var targetID = this.getAttribute("href");
      var targetElement = document.querySelector(targetID);
      if (targetElement) {
        smoothScrollTo(targetElement, 1000); // Duration is set to 1000ms (1 second)
      }
    });
  });

