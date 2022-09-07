<div class="menu">
    @if (config('library.tiptap.toolbar.enabled', true))
        <div class="border-b border-gray-200 divide-x divide-gray-200 flex items-center">
            <div class="px-2 py-1.5">
                @if (config('library.tiptap.toolbar.items.bold', true))
                    <x-library::tiptap.button title="Bold" isActive="'bold'" x-on:click="editor().chain().focus().toggleBold().run()">
                        <x-coolicon-bold class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.italic', true))
                    <x-library::tiptap.button title="Italic" isActive="'italic'" x-on:click="editor().chain().focus().toggleItalic().run()">
                        <x-coolicon-italic class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.underline', true))
                    <x-library::tiptap.button title="Underline" isActive="'underline'" x-on:click="editor().chain().focus().toggleUnderline().run()">
                        <x-coolicon-underline class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.strike', true))
                    <x-library::tiptap.button title="Strike" isActive="'strike'" x-on:click="editor().chain().focus().toggleStrike().run()">
                        <x-coolicon-strikethrough class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.link', true))
                    <x-library::tiptap.button title="Link" isActive="'link'" x-on:click="showLinkModal">
                        <x-coolicon-link-02 class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
                @if (config('library.tiptap.toolbar.items.remove_link', true))
                    <x-library::tiptap.button title="Remove Link" x-on:click="editor().commands.unsetLink()">
                        <x-coolicon-unlink class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.image', true))
                    <x-library::tiptap.button title="Image" x-on:click="showImageModal">
                        <x-coolicon-image class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.code', true))
                    <x-library::tiptap.button title="Code" isActive="'code'" x-on:click="editor().chain().focus().toggleCode().run()">
                        <x-coolicon-code class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
            </div>
            <div class="px-2 pt-2">
                @if (config('library.tiptap.toolbar.items.heading_1', true))
                    <x-library::tiptap.button title="Heading 1" isActive="'heading', { level: 1 }" x-on:click="editor().chain().focus().toggleHeading({ level: 1 }).run()">
                        <x-coolicon-heading-h1 class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.heading_2', true))
                    <x-library::tiptap.button title="Heading 2" isActive="'heading', { level: 2 }" x-on:click="editor().chain().focus().toggleHeading({ level: 2 }).run()">
                        <x-coolicon-heading-h2 class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.heading_3', true))
                    <x-library::tiptap.button title="Heading 3" isActive="'heading', { level: 3 }" x-on:click="editor().chain().focus().toggleHeading({ level: 3 }).run()">
                        <x-coolicon-heading-h3 class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.heading_4', true))
                    <x-library::tiptap.button title="Heading 4" isActive="'heading', { level: 4 }" x-on:click="editor().chain().focus().toggleHeading({ level: 4 }).run()">
                        <x-coolicon-heading-h4 class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.bullet_list', true))
                    <x-library::tiptap.button title="Bullet List" isActive="'bulletList'" x-on:click="editor().chain().focus().toggleBulletList().run()">
                        <x-coolicon-list-ul class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.ordered_list', true))
                    <x-library::tiptap.button title="Ordered List" isActive="'orderedList'" x-on:click="editor().chain().focus().toggleOrderedList().run()">
                        <x-coolicon-list-ol class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.task_list', true))
                    <x-library::tiptap.button title="Task List" isActive="'taskList'" x-on:click="editor().chain().focus().toggleTaskList().run()">
                        <x-coolicon-list-checklist-alt class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.code_block', true))
                    <x-library::tiptap.button title="Code Block" isActive="'codeBlock'" x-on:click="editor().chain().focus().toggleCodeBlock().run()">
                        <x-coolicon-window-code-block class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.table', true))
                    <x-library::tiptap.button title="Insert Table" x-on:click="editor().chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()">
                        <x-coolicon-table-add class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
            </div>
            <div class="px-2 pt-2">
                @if (config('library.tiptap.toolbar.items.align_left', true))
                    <x-library::tiptap.button title="Align Left" isActive="{textAlign: 'left'}" x-on:click="editor().chain().focus().setTextAlign('left').run()">
                        <x-coolicon-text-align-left class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.align_center', true))
                    <x-library::tiptap.button title="Align Center" isActive="{textAlign: 'center'}" x-on:click="editor().chain().focus().setTextAlign('center').run()">
                        <x-coolicon-text-align-center class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.align_center', true))
                    <x-library::tiptap.button title="Align Right" isActive="{textAlign: 'right'}" x-on:click="editor().chain().focus().setTextAlign('right').run()">
                        <x-coolicon-text-align-right class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.align_justify', true))
                    <x-library::tiptap.button title="Align Justify" isActive="{textAlign: 'justify'}" x-on:click="editor().chain().focus().setTextAlign('justify').run()">
                        <x-coolicon-text-align-justify class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
            </div>
            <div class="px-2 pt-2">
                @if (config('library.tiptap.toolbar.items.blockquote', true))
                    <x-library::tiptap.button title="Blockquote" isActive="'blockquote'" x-on:click="editor().chain().focus().toggleBlockquote().run()">
                        <x-coolicon-double-quotes-l class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
                {{--                        <x-library::tiptap.button title="Highlight" isActive="highlight" x-on:click="editor().chain().focus().toggleHighlight().run()">--}}
                {{--                            <x-coolicon-edit class="w-5 h-5"/>--}}
                {{--                        </x-library::tiptap.button>--}}

                @if (config('library.tiptap.toolbar.items.horizontal_rule', true))
                    <x-library::tiptap.button title="Horizontal Rule" x-on:click="editor().chain().focus().setHorizontalRule().run()">
                        <x-coolicon-line-l class="w-5 h-5 transform rotate-90"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.line_break', true))
                    <x-library::tiptap.button title="Line Break" x-on:click="editor().chain().focus().setHardBreak().run()">
                        <x-coolicon-line-break class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
            </div>
            <div class="px-2 pt-2">
                @if (config('library.tiptap.toolbar.items.clear_format', true))
                    <x-library::tiptap.button title="Clear Format" x-on:click="editor().chain().focus().clearNodes().unsetAllMarks().run()">
                        <x-coolicon-cookie class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.undo', true))
                    <x-library::tiptap.button title="Undo" x-on:click="editor().chain().focus().undo().run()">
                        <x-coolicon-undo class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif

                @if (config('library.tiptap.toolbar.items.redo', true))
                    <x-library::tiptap.button title="Redo" x-on:click="editor().chain().focus().redo().run()">
                        <x-coolicon-redo class="w-5 h-5"/>
                    </x-library::tiptap.button>
                @endif
                {{--        <x-library::tiptap.button title="Drafts" x-on:click="">--}}
                {{--            <x-coolicon-window class="w-5 h-5"/>--}}
                {{--        </x-library::tiptap.button>--}}
            </div>
        </div>
    @endif

    <!-- Bubble Menu -->
    @if (config('library.tiptap.bubble_menu.enabled', true))
        <template x-if="typeof isActive !== 'undefined'" id="bubble-menu" class="divide-x divide-gray-200 flex items-center">
            <div>
                <x-library::tiptap.button title="Bold" isActive="'bold'" x-on:click="editor().chain().focus().toggleBold().run()">
                    <x-coolicon-bold class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Italic" isActive="'italic'" x-on:click="editor().chain().focus().toggleItalic().run()">
                    <x-coolicon-italic class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Link" isActive="'link'" x-on:click="showLinkModal">
                    <x-coolicon-link-02 class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Remove Link" x-on:click="editor().commands.unsetLink()">
                    <x-coolicon-unlink class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Heading 1" isActive="'heading', { level: 1 }" x-on:click="editor().chain().focus().toggleHeading({ level: 1 }).run()">
                    <x-coolicon-heading-h1 class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Heading 2" isActive="'heading', { level: 2 }" x-on:click="editor().chain().focus().toggleHeading({ level: 2 }).run()">
                    <x-coolicon-heading-h2 class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Heading 3" isActive="'heading', { level: 3 }" x-on:click="editor().chain().focus().toggleHeading({ level: 3 }).run()">
                    <x-coolicon-heading-h3 class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Heading 4" isActive="'heading', { level: 4 }" x-on:click="editor().chain().focus().toggleHeading({ level: 4 }).run()">
                    <x-coolicon-heading-h4 class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Bullet List" isActive="'bulletList'" x-on:click="editor().chain().focus().toggleBulletList().run()">
                    <x-coolicon-list-ul class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Ordered List" isActive="'orderedList'" x-on:click="editor().chain().focus().toggleOrderedList().run()">
                    <x-coolicon-list-ol class="w-5 h-5"/>
                </x-library::tiptap.button>
                <x-library::tiptap.button title="Merge/Split Cells" x-show="editor().can().mergeOrSplit()" x-on:click="editor().chain().focus().mergeOrSplit().run()">
                    <x-coolicon-combine-cells class="w-5 h-5"/>
                </x-library::tiptap.button>
            </div>
        </template>
    @endif

    <!-- Bubble Menu for Image -->
    <template x-if="typeof isActive !== 'undefined'" id="bubble-menu-for-image" class="divide-x divide-gray-200 flex items-center">
        <div>
            <x-library::tiptap.button title="Align Left" isActive="'custom-image', { align: 'justify-start' }" x-on:click="editor().chain().focus().setImageAlign({align: 'justify-start'}).run()">
                <x-coolicon-text-align-left class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Align Center" isActive="'custom-image', { align: 'justify-center' }" x-on:click="editor().chain().focus().setImageAlign({align: 'justify-center'}).run()">
                <x-coolicon-text-align-center class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Align Right" isActive="'custom-image', { align: 'justify-end' }" x-on:click="editor().chain().focus().setImageAlign({align: 'justify-end'}).run()">
                <x-coolicon-text-align-right class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Edit Image" x-on:click="showImageModal">
                <x-coolicon-edit class="w-5 h-5"/>
            </x-library::tiptap.button>
        </div>
    </template>

    <!-- Bubble Menu for Table -->
    <template x-if="typeof isActive !== 'undefined'" id="bubble-menu-for-table" class="divide-x divide-gray-200 flex items-center">
        <div>
            <x-library::tiptap.button title="Add Column" x-on:click="editor().chain().focus().addColumnAfter().run()">
                <x-coolicon-add-column class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Delete Column" x-on:click="editor().chain().focus().deleteColumn().run()">
                <x-coolicon-delete-column class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Add Row" x-on:click="editor().chain().focus().addRowAfter().run()">
                <x-coolicon-add-row class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Delete Row" x-on:click="editor().chain().focus().deleteRow().run()">
                <x-coolicon-delete-row class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Delete Table" x-on:click="editor().chain().focus().deleteTable().run()">
                <x-coolicon-table-delete class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Toggle Header Row" x-on:click="editor().chain().focus().toggleHeaderRow().run()">
                <x-coolicon-bar-top class="w-5 h-5"/>
            </x-library::tiptap.button>
        </div>
    </template>

    <!-- Floating Menu -->
    @if (config('library.tiptap.floating_menu.enabled', true))
        <template x-if="typeof isActive !== 'undefined'" id="floating-menu" class="divide-x divide-gray-200 flex items-center">
        <div>
            <x-library::tiptap.button title="Heading 1" isActive="'heading', { level: 1 }" x-on:click="editor().chain().focus().toggleHeading({ level: 1 }).run()">
                <x-coolicon-heading-h1 class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Heading 2" isActive="'heading', { level: 2 }" x-on:click="editor().chain().focus().toggleHeading({ level: 2 }).run()">
                <x-coolicon-heading-h2 class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Heading 3" isActive="'heading', { level: 3 }" x-on:click="editor().chain().focus().toggleHeading({ level: 3 }).run()">
                <x-coolicon-heading-h3 class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Heading 4" isActive="'heading', { level: 4 }" x-on:click="editor().chain().focus().toggleHeading({ level: 4 }).run()">
                <x-coolicon-heading-h4 class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Image" x-on:click="showImageModal">
                <x-coolicon-image class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Bullet List" isActive="'bulletList'" x-on:click="editor().chain().focus().toggleBulletList().run()">
                <x-coolicon-list-ul class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Ordered List" isActive="'orderedList'" x-on:click="editor().chain().focus().toggleOrderedList().run()">
                <x-coolicon-list-ol class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Blockquote" isActive="'blockquote'" x-on:click="editor().chain().focus().toggleBlockquote().run()">
                <x-coolicon-double-quotes-l class="w-5 h-5"/>
            </x-library::tiptap.button>
            <x-library::tiptap.button title="Code Block" isActive="'codeBlock'" x-on:click="editor().chain().focus().toggleCodeBlock().run()">
                <x-coolicon-window-code-block class="w-5 h-5"/>
            </x-library::tiptap.button>
        </div>
    </template>
    @endif
</div>
