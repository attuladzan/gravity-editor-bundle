/**
 * Plugin registry for Gravity UI Markdown Editor.
 * @see https://github.com/gravity-ui/markdown-editor/tree/main/docs
 */
import { Mermaid } from '@gravity-ui/markdown-editor/extensions/additional/Mermaid/index.js';
import { Math } from '@gravity-ui/markdown-editor/extensions/additional/Math/index.js';
import { YfmHtmlBlock } from '@gravity-ui/markdown-editor/extensions/additional/YfmHtmlBlock/index.js';
import {
  wMermaidItemData,
  wMathInlineItemData,
  wMathBlockItemData,
  wYfmHtmlBlockItemData,
} from '@gravity-ui/markdown-editor';

const PLUGINS = {
  mermaid: {
    extension: Mermaid,
    options: () => ({ loadRuntimeScript: () => import('@diplodoc/mermaid-extension/runtime') }),
    actions: [wMermaidItemData],
  },
  latex: {
    extension: Math,
    options: () => ({
      loadRuntimeScript: () =>
        Promise.all([
          import('@diplodoc/latex-extension/runtime'),
          import('@diplodoc/latex-extension/runtime/styles'),
        ]),
    }),
    actions: [wMathInlineItemData, wMathBlockItemData],
  },
  html: {
    extension: YfmHtmlBlock,
    options: () => ({}),
    actions: [wYfmHtmlBlockItemData],
  },
};

/**
 * @param {string[]} enabledPlugins
 * @returns {{ extraExtensions?: Function, commandMenuActions: Array }}
 */
export function buildPluginConfig(enabledPlugins) {
  const extensionLoaders = [];
  const commandMenuActions = [];

  for (const name of enabledPlugins) {
    const plugin = PLUGINS[name];
    if (!plugin) continue;

    extensionLoaders.push({ extension: plugin.extension, options: plugin.options() });
    commandMenuActions.push(...plugin.actions);
  }

  const extraExtensions =
    extensionLoaders.length > 0
      ? (builder) => extensionLoaders.forEach(({ extension, options }) => builder.use(extension, options))
      : undefined;

  return { extraExtensions, commandMenuActions };
}
