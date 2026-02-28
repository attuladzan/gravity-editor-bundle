/**
 * Gravity UI Markdown Editor - bundle entry.
 * Exposes window.GravityUIMarkdownEditorInit for iframe hydration.
 * Syncs editor content to parent textarea on change.
 */
import '@gravity-ui/uikit/styles/fonts.css';
import '@gravity-ui/uikit/styles/styles.css';
import React, { useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { ThemeProvider, ToasterProvider, ToasterComponent } from '@gravity-ui/uikit';
import { toaster } from '@gravity-ui/uikit/toaster-singleton';
import { configure as configureUikit } from '@gravity-ui/uikit';
import { useMarkdownEditor, MarkdownEditorView, configure } from '@gravity-ui/markdown-editor';

function EditorWrapper({ textareaId, editorOpts, viewOpts }) {
  const editor = useMarkdownEditor(editorOpts, []);

  useEffect(() => {
    window.__GMD_EDITOR__ = editor;
    return () => { window.__GMD_EDITOR__ = null; };
  }, [editor]);

  useEffect(() => {
    if (!textareaId || !editor) return;
    const doc = window.parent?.document || document;
    const sync = () => {
      if (typeof editor.getValue !== 'function') return;
      const target = doc.getElementById(textareaId);
      if (target) target.value = editor.getValue();
    };
    sync();
    editor.on('change', sync);
    return () => editor.off('change', sync);
  }, [editor, textareaId]);

  return React.createElement(MarkdownEditorView, {
    editor,
    stickyToolbar: true,
    ...viewOpts,
  });
}

function App({ textareaId, editorOpts, viewOpts }) {
  return React.createElement(
    ThemeProvider,
    { theme: 'light' },
    React.createElement(
      ToasterProvider,
      { toaster },
      React.createElement(EditorWrapper, { textareaId, editorOpts, viewOpts }),
      React.createElement(ToasterComponent, { toaster }),
    ),
  );
}

window.GravityUIMarkdownEditorInit = function (id, mount, _textarea, cfg) {
  const initialMarkup = cfg?.initial?.markup ?? '';
  const editorCfg = cfg?.editor ?? {};
  const editorOpts = {
    ...editorCfg,
    md: {
      ...(editorCfg.md ?? {}),
      html: editorCfg.allow_html ?? editorCfg.md?.html ?? false,
    },
    initial: {
      ...(editorCfg.initial ?? {}),
      markup: initialMarkup,
    },
  };
  delete editorOpts.allow_html;

  const viewOpts = cfg?.view ?? {};
  const lang = cfg?.lang ?? 'en';

  configureUikit({ lang });
  configure({ lang });

  try {
    const root = createRoot(mount);
    root.render(React.createElement(App, {
      textareaId: id,
      editorOpts,
      viewOpts,
    }));
  } catch (err) {
    console.error('[Gravity Markdown Editor] Init failed:', err);
  }
};
