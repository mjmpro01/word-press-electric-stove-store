/* KitFix24H — main.js */
(function () {
  "use strict";

  /* ── Sticky header shadow ── */
  var header = document.getElementById("kf-header");
  if (header) {
    window.addEventListener(
      "scroll",
      function () {
        header.classList.toggle("scrolled", window.scrollY > 10);
      },
      { passive: true },
    );
  }

  /* ── Mobile menu toggle ── */
  var toggle = document.getElementById("kf-menu-toggle");
  var mobileNav = document.getElementById("kf-mobile-nav");
  if (toggle && mobileNav) {
    toggle.addEventListener("click", function () {
      var isOpen = mobileNav.classList.toggle("open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
      mobileNav.setAttribute("aria-hidden", isOpen ? "false" : "true");
    });
  }

  /* ── Pricing accordion ── */
  document.querySelectorAll("[data-pricing-toggle]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var body = btn.parentElement.querySelector(".kf-pricing-body");
      var chevron = btn.querySelector(".kf-pricing-toggle-chevron");
      if (!body) return;
      var isOpen = !body.hidden;
      // Close all
      document.querySelectorAll(".kf-pricing-body").forEach(function (b) {
        b.hidden = true;
      });
      document
        .querySelectorAll(".kf-pricing-toggle-chevron")
        .forEach(function (c) {
          c.classList.remove("open");
        });
      // Toggle clicked
      if (!isOpen) {
        body.hidden = false;
        if (chevron) chevron.classList.add("open");
      }
    });
  });

  /* ── Quick booking form (homepage) ── */
  var quickForm = document.getElementById("kf-quick-booking");
  var quickSuccess = document.getElementById("kf-booking-success");
  if (quickForm && quickSuccess) {
    quickForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var data = new FormData(quickForm);
      data.append("action", "kitfix_submit_booking");
      var submitBtn = quickForm.querySelector('[type="submit"]');
      if (submitBtn) submitBtn.disabled = true;

      fetch(KITFIX.ajaxUrl, { method: "POST", body: data })
        .then(function (r) {
          var clone = r.clone();
          return r.json().catch(function () {
            return clone.text().then(function (txt) {
              console.error("[KitFix] AJAX raw response:", txt);
              return {
                success: false,
                data: { message: "Lỗi server. Kiểm tra console." },
              };
            });
          });
        })
        .then(function (res) {
          console.log("[KitFix] quick booking response:", res);
          if (res && res.success) {
            quickForm.hidden = true;
            quickSuccess.hidden = false;
            var resetBtn = quickSuccess.querySelector("button");
            if (resetBtn)
              resetBtn.addEventListener("click", function () {
                quickForm.reset();
                quickForm.hidden = false;
                quickSuccess.hidden = true;
                if (submitBtn) submitBtn.disabled = false;
              });
          } else {
            var msg =
              res && res.data && res.data.message
                ? res.data.message
                : "Có lỗi xảy ra. Vui lòng gọi: 0918.611.092";
            alert(msg);
            if (submitBtn) submitBtn.disabled = false;
          }
        })
        .catch(function () {
          alert("Không thể kết nối. Vui lòng gọi: 0918.611.092");
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  }

  /* ── Multi-step booking form ── */
  var msForm = document.getElementById("kf-multistep-booking");
  if (msForm) {
    var currentStep = 0;
    var totalSteps = 4;
    var btnNext = document.getElementById("kf-step-next");
    var btnBack = document.getElementById("kf-step-back");
    var btnSubmit = document.getElementById("kf-step-submit");
    var successEl = document.getElementById("kf-booking-success-full");
    var newBookingBtn = document.getElementById("kf-new-booking");

    function updateStepUI() {
      document.querySelectorAll("[data-step-panel]").forEach(function (panel) {
        panel.hidden = Number(panel.dataset.stepPanel) !== currentStep;
      });
      document.querySelectorAll(".kf-step-circle").forEach(function (circle) {
        var s = Number(circle.dataset.step);
        circle.className =
          "kf-step-circle " +
          (s < currentStep ? "done" : s === currentStep ? "active" : "pending");
        var lbl =
          circle.parentElement &&
          circle.parentElement.querySelector(".kf-step-label");
        if (lbl)
          lbl.className =
            "kf-step-label" + (s === currentStep ? " active" : "");
      });
      document
        .querySelectorAll(".kf-step-connector-line")
        .forEach(function (line) {
          var idx = Number(line.dataset.connector);
          line.className =
            "kf-step-connector-line" + (idx < currentStep ? " done" : "");
        });
      btnBack &&
        (btnBack.style.display = currentStep > 0 ? "inline-flex" : "none");
      btnNext &&
        (btnNext.style.display =
          currentStep < totalSteps - 1 ? "inline-flex" : "none");
      btnSubmit &&
        (btnSubmit.style.display =
          currentStep === totalSteps - 1 ? "inline-flex" : "none");
      if (currentStep === totalSteps - 1) buildConfirmSummary();
    }

    function buildConfirmSummary() {
      var el = document.getElementById("kf-confirm-summary");
      if (!el) return;
      var fields = [
        ["Thiết bị", document.querySelector('[name="booking_service"]')],
        ["Thương hiệu", document.querySelector('[name="booking_brand"]')],
        ["Mô tả lỗi", document.querySelector('[name="booking_symptoms"]')],
        ["Khách hàng", document.getElementById("b_name")],
        ["Điện thoại", document.getElementById("b_phone")],
        ["Địa chỉ", document.getElementById("b_address")],
        ["Quận/Huyện", document.getElementById("b_district")],
        ["Ngày hẹn", document.getElementById("b_date")],
        ["Khung giờ", document.querySelector('[name="booking_time"]')],
        ["Ghi chú", document.querySelector('[name="booking_note"]')],
      ];
      el.innerHTML = fields
        .filter(function (f) {
          return f[1] && f[1].value;
        })
        .map(function (f) {
          return (
            '<div class="kf-confirm-row"><span class="kf-confirm-key">' +
            f[0] +
            '</span><span class="kf-confirm-val">' +
            f[1].value +
            "</span></div>"
          );
        })
        .join("");
    }

    // Service buttons
    document.querySelectorAll(".kf-svc-btn").forEach(function (btn) {
      btn.addEventListener("click", function () {
        document.querySelectorAll(".kf-svc-btn").forEach(function (b) {
          b.classList.remove("selected");
        });
        btn.classList.add("selected");
        var hidden = document.getElementById("booking_service_hidden");
        if (hidden) hidden.value = btn.dataset.value;
      });
    });

    // Time slot buttons
    document.querySelectorAll(".kf-time-slot").forEach(function (btn) {
      btn.addEventListener("click", function () {
        document.querySelectorAll(".kf-time-slot").forEach(function (b) {
          b.classList.remove("selected");
        });
        btn.classList.add("selected");
        var hidden = document.getElementById("booking_time_hidden");
        if (hidden) hidden.value = btn.dataset.value;
      });
    });

    function validateStep(step) {
      if (step === 0) {
        var svcHidden = document.getElementById("booking_service_hidden");
        if (!svcHidden || !svcHidden.value) {
          alert("Vui lòng chọn thiết bị cần sửa.");
          return false;
        }
      }
      if (step === 1) {
        var name = document.getElementById("b_name");
        var phone = document.getElementById("b_phone");
        var address = document.getElementById("b_address");
        var district = document.getElementById("b_district");
        if (!name || !name.value.trim()) {
          alert("Vui lòng nhập họ và tên.");
          name && name.focus();
          return false;
        }
        if (!phone || !phone.value.trim()) {
          alert("Vui lòng nhập số điện thoại.");
          phone && phone.focus();
          return false;
        }
        if (!address || !address.value.trim()) {
          alert("Vui lòng nhập địa chỉ.");
          address && address.focus();
          return false;
        }
        if (!district || !district.value) {
          alert("Vui lòng chọn quận/huyện.");
          district && district.focus();
          return false;
        }
      }
      if (step === 2) {
        var date = document.getElementById("b_date");
        var timeHidden = document.getElementById("booking_time_hidden");
        if (!date || !date.value) {
          alert("Vui lòng chọn ngày hẹn.");
          date && date.focus();
          return false;
        }
        if (!timeHidden || !timeHidden.value) {
          alert("Vui lòng chọn khung giờ.");
          return false;
        }
      }
      return true;
    }

    btnNext &&
      btnNext.addEventListener("click", function () {
        if (currentStep < totalSteps - 1 && validateStep(currentStep)) {
          currentStep++;
          updateStepUI();
        }
      });
    btnBack &&
      btnBack.addEventListener("click", function () {
        if (currentStep > 0) {
          currentStep--;
          updateStepUI();
        }
      });

    msForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var data = new FormData(msForm);
      data.append("action", "kitfix_submit_booking");
      btnSubmit && (btnSubmit.disabled = true);

      fetch(KITFIX.ajaxUrl, { method: "POST", body: data })
        .then(function (r) {
          var clone = r.clone();
          return r.json().catch(function () {
            return clone.text().then(function (txt) {
              console.error("[KitFix] AJAX raw response:", txt);
              return {
                success: false,
                data: { message: "Lỗi server. Kiểm tra console để biết thêm." },
              };
            });
          });
        })
        .then(function (res) {
          console.log("[KitFix] booking response:", res);
          if (res && res.success) {
            msForm.hidden = true;
            if (successEl) successEl.hidden = false;
          } else {
            var msg =
              res && res.data && res.data.message
                ? res.data.message
                : "Có lỗi xảy ra. Vui lòng gọi điện trực tiếp: 0918.611.092";
            alert(msg);
            btnSubmit && (btnSubmit.disabled = false);
          }
        })
        .catch(function (err) {
          console.error("[KitFix] fetch error:", err);
          alert("Không thể kết nối. Vui lòng gọi điện trực tiếp: 0918.611.092");
          btnSubmit && (btnSubmit.disabled = false);
        });
    });

    newBookingBtn &&
      newBookingBtn.addEventListener("click", function () {
        msForm.reset();
        currentStep = 0;
        msForm.hidden = false;
        if (successEl) successEl.hidden = true;
        updateStepUI();
      });

    updateStepUI();
  }

  /* ── Service page booking form ── */
  var svcForm = document.getElementById("kf-service-booking");
  if (svcForm) {
    svcForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var data = new FormData(svcForm);
      data.append("action", "kitfix_submit_booking");
      fetch(KITFIX.ajaxUrl, { method: "POST", body: data })
        .catch(function () {
          return {};
        })
        .then(function () {
          svcForm.innerHTML =
            '<div style="text-align:center;padding:20px;"><div style="font-size:18px;font-weight:700;color:#10B981;margin-bottom:8px;">✓ Đặt lịch thành công!</div><p style="color:#5C6E87;font-size:14px;">Chúng tôi sẽ gọi lại trong 15 phút.</p></div>';
        });
    });
  }

  /* ── Set min date for date input ── */
  document.querySelectorAll('input[type="date"]').forEach(function (input) {
    if (!input.min) {
      input.min = new Date().toISOString().split("T")[0];
    }
  });
})();
