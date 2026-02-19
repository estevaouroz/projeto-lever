(function ($) {
  "use strict";

  const $scanBtn = $("#lwm-scan-btn");
  const $convertBtn = $("#lwm-convert-btn");
  const $progressBar = $("#lwm-progress-bar");
  const $progressLabel = $("#lwm-progress-label");
  const $summary = $("#lwm-scan-summary");
  const $log = $("#lwm-log");
  const $dryRun = $("#lwm-dry-run");

  $dryRun.prop("checked", false);

  let isRunning = false;

  function setProgress(progress, stage) {
    const dryRunLabel = $dryRun.is(":checked") ? "[DRY-RUN] " : "";
    $progressBar.css("width", `${progress}%`);
    $progressLabel.text(
      `Etapa: ${dryRunLabel}${stage} | Progresso: ${progress}%`,
    );
  }

  function refreshLog() {
    return $.post(LWM_ADMIN.ajaxUrl, {
      action: "lwm_get_log",
      nonce: LWM_ADMIN.nonce,
    }).done((res) => {
      if (res && res.success) {
        $log.text(res.data.log || "");
      }
    });
  }

  $scanBtn.on("click", function () {
    if (isRunning) {
      return;
    }

    setProgress(0, "scan");
    $convertBtn.prop("disabled", true);
    $.post(LWM_ADMIN.ajaxUrl, {
      action: "lwm_scan",
      nonce: LWM_ADMIN.nonce,
    })
      .done((res) => {
        if (!res || !res.success) {
          alert((res && res.data && res.data.message) || "Falha no scan");
          return;
        }

        $summary.text(JSON.stringify(res.data.scan, null, 2));
        setProgress(10, "scan concluído | clique em Convert");
        $convertBtn.prop("disabled", false);
        refreshLog();
      })
      .fail(() => {
        $convertBtn.prop("disabled", false);
        setProgress(0, "falha no scan");
        alert("Erro no scan");
      });
  });

  function runBatch() {
    isRunning = true;
    $scanBtn.prop("disabled", true);
    $convertBtn.prop("disabled", true);

    $.post(LWM_ADMIN.ajaxUrl, {
      action: "lwm_run_batch",
      nonce: LWM_ADMIN.nonce,
      dry_run: $dryRun.is(":checked") ? 1 : 0,
      batch: 20,
      quality: 85,
    })
      .done((res) => {
        if (!res || !res.success) {
          isRunning = false;
          $scanBtn.prop("disabled", false);
          $convertBtn.prop("disabled", false);
          setProgress(0, "falha na conversão");
          alert(
            (res && res.data && res.data.message) ||
              "Falha no processamento em lote",
          );
          return;
        }

        const data = res.data || {};
        const stage = data.stage || "unknown";
        const progress = Number(data.progress || 0);

        setProgress(progress, stage);
        refreshLog();

        if (stage !== "done") {
          window.setTimeout(runBatch, 250);
        } else {
          isRunning = false;
          $scanBtn.prop("disabled", false);
          $convertBtn.prop("disabled", false);
        }
      })
      .fail((xhr) => {
        isRunning = false;
        $scanBtn.prop("disabled", false);
        $convertBtn.prop("disabled", false);
        setProgress(0, "erro no processamento em lote");
        const details =
          (xhr &&
            xhr.responseJSON &&
            xhr.responseJSON.data &&
            (xhr.responseJSON.data.reason || xhr.responseJSON.data.message)) ||
          (xhr && xhr.responseText
            ? String(xhr.responseText).slice(0, 300)
            : "");

        alert(`Erro no processamento em lote${details ? `: ${details}` : ""}`);
      });
  }

  $convertBtn.on("click", function () {
    if ($dryRun.is(":checked")) {
      const ok = window.confirm(
        "Dry-run está ativo: esta execução é apenas simulação e não vai gerar arquivos .webp. Deseja continuar?",
      );
      if (!ok) {
        return;
      }
    }

    setProgress(5, "iniciando");
    runBatch();
  });
})(jQuery);
