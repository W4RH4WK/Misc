(add-to-list 'custom-theme-load-path "~/.emacs.d/themes/")

;; Visuals
(load-theme 'molokai t)
(menu-bar-mode +1)
(tool-bar-mode -1)
(global-hl-line-mode t)
(blink-cursor-mode 0)

;; Handling
(defalias 'yes-or-no-p 'y-or-n-p)
(setq mouse-autoselect-window t)
(setq scroll-error-top-bottom 1)
(global-set-key (kbd "C-z") 'nil)

;; Indent
(setq-default indent-tabs-mode nil)
(setq-default tab-width 4)

;; Files
(setq make-backup-files nil)
(setq auto-save-default nil)

;; Packages
(require 'package)
(setq package-enable-at-startup nil)
(add-to-list 'package-archives
             '("melpa" . "http://melpa.org/packages/"))

(package-initialize)

(unless (package-installed-p 'use-package)
  (package-refresh-contents)
  (package-install 'use-package))

;; --------------------------------------------------------------------------
;; E V I L
(use-package evil
 :ensure t
 :init
 (setq evil-default-state 'emacs)
 (setq evil-want-C-u-scroll t)
 (evil-mode t)
 :config
 (evil-set-initial-state 'term-mode 'emacs))
 ;;:bind
 ;;("M-u" . universal-argument)
 ;;("<mouse-8>" . evil-jump-backward)
 ;;("<mouse-9>" . evil-jump-forward))

(use-package evil-nerd-commenter
  :ensure t
  :bind
  ("M-;"   . evilnc-comment-or-uncomment-lines)
  ("C-M-;" . comment-indent))

;; H E L M
(use-package helm
  :ensure t
  :diminish helm-mode
  :config
  (setq helm-M-x-fuzzy-match t)
  (helm-mode t)
  :bind
  ("M-x" . helm-M-x)
  ("C-x C-f" . helm-find-files)
  ("C-x C-b" . helm-buffers-list))

(use-package helm-descbinds
  :ensure t
  :config
  (helm-descbinds-mode))

(use-package helm-fuzzier
  :ensure t
  :config
  (helm-fuzzier-mode 1))

;; O T H E R
;; (use-package back-button
;;   :ensure t
;;   :init
;;   (back-button-mode 1))

(use-package dired+
 :load-path "site-lisp/dired+"
 :config
 (define-key dired-mode-map (kbd "<mouse-2>") 'diredp-mouse-find-file-reuse-dir-buffer))

(use-package diminish :ensure t)

(use-package linum                      ; replace in EMACS 26.1
  :ensure t
  :config
  (setq linum-format "%3d ")
  (set-face-attribute 'linum nil :foreground "gray30" :background "#232526"))

(use-package paren
  :ensure t
  :config
  (set-face-attribute 'show-paren-match nil :background "gray30"))

(use-package spaceline
  :ensure t
  :init
  (require 'spaceline-config)
  (setq spaceline-highlight-face-func 'spaceline-highlight-face-evil-state)
  (setq powerline-default-separator nil)
  (setq spaceline-battery-p nil)
  :config
  (spaceline-spacemacs-theme))

(use-package saveplace                  ; replace in EMACS 25.1
  :ensure t
  :init
  (setq-default save-place t))

(use-package undo-tree
  :ensure t
  :diminish undo-tree-mode
  :init
  (global-undo-tree-mode))

(use-package which-key
  :ensure t
  :diminish which-key-mode
  :init
  (which-key-mode))

(use-package whitespace
  :ensure t
  :diminish whitespace-mode
  :config
  (setq whitespace-display-mappings '((space-mark   ?\    [?·]     [?·])
                                      (space-mark   ?\xA0 [?¤]     [?_])
                                      (newline-mark ?\n   [?¬ ?\n])))
                                      ;;(tab-mark     ?\t   [?» ?\t] [?\\ ?\t])))
  (setq-default whitespace-style '(face tabs spaces trailing newline space-mark tab-mark newline-mark))
  (set-face-attribute 'whitespace-newline  nil :foreground "gray30" :background nil)
  (set-face-attribute 'whitespace-space    nil :foreground "gray30" :background nil)
  (set-face-attribute 'whitespace-tab      nil :foreground "gray30" :background nil)
  (set-face-attribute 'whitespace-trailing nil :foreground "gray30" :background "dark red"))

;;(use-package projectile :ensure t)
;;(use-package company :ensure t)
;;(use-package flycheck :ensure t)
;;(use-package magit :ensure t)
;;(use-package git-gutter :ensure t)
