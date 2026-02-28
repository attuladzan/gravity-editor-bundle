/**
 * Gravity UI Markdown Editor - iframe entry point.
 * @see https://github.com/gravity-ui/markdown-editor
 */
import '@gravity-ui/uikit/styles/fonts.css';
import '@gravity-ui/uikit/styles/styles.css';
import React, { useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { ThemeProvider, ToasterProvider, ToasterComponent } from '@gravity-ui/uikit';
import { toaster } from '@gravity-ui/uikit/toaster-singleton';
import { configure as configureUikit } from '@gravity-ui/uikit';
import { useMarkdownEditor, MarkdownEditorView, configure, wysiwygToolbarConfigs } from '@gravity-ui/markdown-editor';
import { buildPluginConfig } from './plugins.js';

function EditorWrapper({ textareaId, editorOpts, viewOpts }) {
  const editor = useMarkdownEditor(editorOpts, []);

  useEffect(() => {
    window.__GMD_EDITOR__ = editor;
    return () => { window.__GMD_EDITOR__ = null; };
  }, [editor]);

  useEffect(() => {
    if (!textareaId || !editor?.getValue) return;
    const doc = window.parent?.document ?? document;
    const sync = () => {
      const el = doc.getElementById(textareaId);
      if (el) el.value = editor.getValue();
    };
    sync();
    editor.on('change', sync);
    return () => editor.off('change', sync);
  }, [editor, textareaId]);

  return React.createElement(MarkdownEditorView, { editor, stickyToolbar: true, ...viewOpts });
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
  const cfgPlugins = cfg?.plugins;
  const enabledPlugins = Array.isArray(cfgPlugins) ? cfgPlugins : [];
  const pluginConfig = buildPluginConfig(enabledPlugins);

  configureUikit({ lang: cfg?.lang ?? 'en' });
  configure({ lang: cfg?.lang ?? 'en' });

  const editorOpts = {
    ...(cfg?.editor ?? {}),
    md: {
      ...(cfg?.editor?.md ?? {}),
      html: cfg?.editor?.allow_html ?? cfg?.editor?.md?.html ?? false,
    },
    initial: {
      ...(cfg?.editor?.initial ?? {}),
      markup: cfg?.initial?.markup ?? '',
    },
    ...(pluginConfig.extraExtensions && {
      wysiwygConfig: {
        extensions: pluginConfig.extraExtensions,
        extensionOptions:
          pluginConfig.commandMenuActions.length > 0
            ? {
                commandMenu: {
                  actions: [...pluginConfig.commandMenuActions, ...(wysiwygToolbarConfigs.wCommandMenuConfig ?? [])],
                },
              }
            : undefined,
      },
    }),
  };
  delete editorOpts.allow_html;

  const root = createRoot(mount);
  try {
    root.render(
      React.createElement(App, {
        textareaId: id,
        editorOpts,
        viewOpts: cfg?.view ?? {},
      }),
    );
  } catch (err) {
    console.error('[Gravity Editor] Init failed:', err);
    root.render(React.createElement('div', { style: { color: 'red', padding: 16 } }, 'Editor failed to load'));
  }
};
