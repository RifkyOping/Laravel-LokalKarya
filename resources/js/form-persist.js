/**
 * LOKALKARYA — Form Persistence via LocalStorage
 * ─────────────────────────────────────────────────────────────
 * Otomatis menyimpan & memulihkan isi form agar user tidak perlu
 * mengisi ulang ketika halaman di-refresh, tab ditutup, atau
 * navigasi tidak sengaja.
 *
 * Cara pakai di blade:
 *   Tambahkan atribut  id="..."  dan  data-persist  pada <form>.
 *   Contoh:
 *     <form id="form-tambah-produk" data-persist ...>
 *
 * Field yang DIKECUALIKAN (tidak pernah disimpan):
 *   • type="password"  → keamanan
 *   • type="file"      → tidak bisa disimpan di localStorage
 *   • type="hidden"    → CSRF token, method-override, dll.
 *   • type="submit" / type="button"
 */

const PERSIST_PREFIX = 'lk_draft_';
const DEBOUNCE_MS    = 400;

// ── Helpers ───────────────────────────────────────────────────

/** Selector untuk semua field yang boleh disimpan */
const FIELD_SELECTOR = [
    'input:not([type="file"])',
    'input:not([type="password"])',
    'input:not([type="hidden"])',
    'input:not([type="submit"])',
    'input:not([type="button"])',
    'textarea',
    'select',
].join(', ');

// Selector gabungan (lebih efisien)
const SAVEABLE_FIELDS = 'input:not([type="file"]):not([type="password"]):not([type="hidden"]):not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]), textarea, select';

function storageKey(formId) {
    return PERSIST_PREFIX + formId;
}

function onReady(fn) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        fn();
    }
}

// ── Core Functions ────────────────────────────────────────────

/**
 * Simpan semua field form ke localStorage.
 */
function saveDraft(formId, form) {
    const draft = {};
    form.querySelectorAll(SAVEABLE_FIELDS).forEach(field => {
        const key = field.id || field.name;
        if (key) draft[key] = field.value;
    });

    // Jangan simpan jika semua field kosong
    const hasContent = Object.values(draft).some(v => v && String(v).trim() !== '');
    if (!hasContent) return;

    try {
        localStorage.setItem(storageKey(formId), JSON.stringify({
            data: draft,
            savedAt: Date.now(),
        }));
    } catch (_) {
        // localStorage penuh atau dinonaktifkan → abaikan
    }
}

/**
 * Pulihkan data dari localStorage ke form.
 * Jika field sudah punya nilai (dari server / old()), data tidak di-override
 * kecuali opsi forceRestore = true.
 *
 * @returns {{ restored: boolean, hasData: boolean }}
 */
function restoreDraft(formId, form, forceRestore = true) {
    try {
        const raw = localStorage.getItem(storageKey(formId));
        if (!raw) return { restored: false, hasData: false };

        const { data } = JSON.parse(raw);
        if (!data) return { restored: false, hasData: false };

        let restoredCount = 0;

        Object.entries(data).forEach(([key, value]) => {
            if (value === null || value === undefined || String(value).trim() === '') return;

            // Cari field berdasarkan id atau name
            let field = form.querySelector('#' + CSS.escape(key));
            if (!field) field = form.querySelector(`[name="${CSS.escape(key)}"]`);
            if (!field) return;

            // Pastikan field masih milik form ini (bukan form lain)
            if (field.closest('form') !== form) return;

            // Lewati jika field sudah berisi nilai & bukan forceRestore
            if (!forceRestore && field.value.trim() !== '') return;

            field.value = value;

            // Trigger event agar event listener lain (preview, validasi, dll.) bereaksi
            field.dispatchEvent(new Event('input',  { bubbles: true }));
            field.dispatchEvent(new Event('change', { bubbles: true }));
            restoredCount++;
        });

        const hasData = Object.values(data).some(v => v && String(v).trim() !== '');
        return { restored: restoredCount > 0, hasData };

    } catch (_) {
        return { restored: false, hasData: false };
    }
}

/**
 * Hapus draft tersimpan untuk form tertentu.
 */
function clearDraft(formId) {
    try {
        localStorage.removeItem(storageKey(formId));
    } catch (_) {}
}

// ── Toast Notification ────────────────────────────────────────

function injectToastStyles() {
    if (document.getElementById('lk-toast-styles')) return;
    const style = document.createElement('style');
    style.id = 'lk-toast-styles';
    style.textContent = `
        @keyframes lkToastIn {
            from { opacity: 0; transform: translateY(12px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0)   scale(1);    }
        }
        @keyframes lkToastOut {
            from { opacity: 1; transform: translateY(0);   }
            to   { opacity: 0; transform: translateY(12px); }
        }
        #lk-draft-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #ffffff;
            border: 1px solid #ede9fe;
            border-left: 4px solid #4f46e5;
            padding: 14px 16px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(79,70,229,.13), 0 2px 8px rgba(0,0,0,.06);
            z-index: 99999;
            animation: lkToastIn .35s cubic-bezier(.34,1.56,.64,1) both;
            max-width: 320px;
            font-family: inherit;
        }
        #lk-draft-toast .lk-toast-inner {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #lk-draft-toast .lk-toast-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        #lk-draft-toast .lk-toast-body { flex: 1; min-width: 0; }
        #lk-draft-toast .lk-toast-title {
            font-weight: 700;
            font-size: 13px;
            margin: 0 0 2px;
            color: #1e1b4b;
        }
        #lk-draft-toast .lk-toast-msg {
            font-size: 11.5px;
            color: #6b7280;
            margin: 0;
            line-height: 1.4;
        }
        #lk-draft-toast .lk-toast-close {
            color: #9ca3af;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            line-height: 1;
            flex-shrink: 0;
            transition: color .2s;
        }
        #lk-draft-toast .lk-toast-close:hover { color: #374151; }
    `;
    document.head.appendChild(style);
}

function showDraftToast(message) {
    injectToastStyles();

    const existing = document.getElementById('lk-draft-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'lk-draft-toast';
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');
    toast.innerHTML = `
        <div class="lk-toast-inner">
            <div class="lk-toast-icon">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="lk-toast-body">
                <p class="lk-toast-title">Draft Dipulihkan ✨</p>
                <p class="lk-toast-msg">${message}</p>
            </div>
            <button class="lk-toast-close" aria-label="Tutup notifikasi">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    // Auto-dismiss setelah 5 detik
    const dismissTimer = setTimeout(() => {
        toast.style.animation = 'lkToastOut .3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 5000);

    toast.querySelector('.lk-toast-close').addEventListener('click', () => {
        clearTimeout(dismissTimer);
        toast.style.animation = 'lkToastOut .3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    });
}

// ── Auto-Discovery (data-persist attribute) ───────────────────

/**
 * Inisialisasi persistence untuk satu form element.
 */
function initFormElement(form) {
    const formId = form.id;
    if (!formId) {
        console.warn('[LK FormPersist] Form tanpa id akan dilewati. Tambahkan atribut id pada form.', form);
        return;
    }

    const toastMessage = form.dataset.persistMessage
        || 'Data yang Anda isi sebelumnya telah dipulihkan kembali.';

    // Pulihkan draft saat halaman dimuat
    const { restored } = restoreDraft(formId, form, true);
    if (restored) {
        setTimeout(() => showDraftToast(toastMessage), 700);
    }

    // Simpan saat ada perubahan input (debounced)
    let saveTimer;
    form.querySelectorAll(SAVEABLE_FIELDS).forEach(field => {
        field.addEventListener('input',  () => { clearTimeout(saveTimer); saveTimer = setTimeout(() => saveDraft(formId, form), DEBOUNCE_MS); });
        field.addEventListener('change', () => { clearTimeout(saveTimer); saveTimer = setTimeout(() => saveDraft(formId, form), DEBOUNCE_MS); });
    });

    // Hapus draft saat form berhasil disubmit
    form.addEventListener('submit', () => clearDraft(formId));
}

/**
 * Scan seluruh halaman untuk form dengan atribut [data-persist],
 * lalu inisialisasi setiap form yang ditemukan.
 */
function autoDiscoverForms() {
    document.querySelectorAll('form[data-persist]').forEach(initFormElement);
}

// Jalankan setelah DOM siap
onReady(autoDiscoverForms);

// ── Public API ────────────────────────────────────────────────

window.LKFormPersist = {
    /** Pulihkan draft secara manual */
    restore: (formId) => {
        const form = document.getElementById(formId);
        if (form) restoreDraft(formId, form, true);
    },
    /** Simpan draft secara manual */
    save: (formId) => {
        const form = document.getElementById(formId);
        if (form) saveDraft(formId, form);
    },
    /** Hapus draft */
    clear: clearDraft,
};

export { autoDiscoverForms, initFormElement, saveDraft, restoreDraft, clearDraft };
