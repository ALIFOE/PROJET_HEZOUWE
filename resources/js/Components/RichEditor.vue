<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'Saisir du texte…' },
    rows: { type: Number, default: 4 },
    simple: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue']);

const editorRef = ref(null);
const isFocused = ref(false);
const isEditing = ref(false);
const isBold = ref(false);
const isItalic = ref(false);
const isUnderline = ref(false);
const isStrike = ref(false);

onMounted(() => {
    if (editorRef.value) {
        editorRef.value.innerHTML = props.modelValue || '';
    }
});

watch(() => props.modelValue, (newVal) => {
    if (!editorRef.value || isEditing.value) return;
    if (editorRef.value.innerHTML !== (newVal || '')) {
        editorRef.value.innerHTML = newVal || '';
    }
});

const onInput = () => {
    emit('update:modelValue', editorRef.value.innerHTML);
};

const updateState = () => {
    isBold.value = document.queryCommandState('bold');
    isItalic.value = document.queryCommandState('italic');
    isUnderline.value = document.queryCommandState('underline');
    isStrike.value = document.queryCommandState('strikeThrough');
};

const exec = (cmd, value = null) => {
    editorRef.value.focus();
    document.execCommand(cmd, false, value);
    updateState();
    onInput();
};

const setBlock = (tag) => exec('formatBlock', tag);
</script>

<template>
    <div class="rich-editor" :class="{ focused: isFocused }">
        <div class="re-toolbar">
            <!-- Mise en forme texte -->
            <button type="button" class="tb-btn" :class="{ active: isBold }" @click="exec('bold')" title="Gras (Ctrl+B)">
                <i class="fas fa-bold"></i>
            </button>
            <button type="button" class="tb-btn" :class="{ active: isItalic }" @click="exec('italic')" title="Italique (Ctrl+I)">
                <i class="fas fa-italic"></i>
            </button>
            <button type="button" class="tb-btn" :class="{ active: isUnderline }" @click="exec('underline')" title="Souligner (Ctrl+U)">
                <i class="fas fa-underline"></i>
            </button>
            <button type="button" class="tb-btn" :class="{ active: isStrike }" @click="exec('strikeThrough')" title="Barré">
                <i class="fas fa-strikethrough"></i>
            </button>

            <template v-if="!simple">
                <div class="tb-sep"></div>

                <!-- Titres -->
                <button type="button" class="tb-btn tb-text" @click="setBlock('h2')" title="Titre 2">H2</button>
                <button type="button" class="tb-btn tb-text" @click="setBlock('h3')" title="Titre 3">H3</button>
                <button type="button" class="tb-btn tb-text" @click="setBlock('p')" title="Paragraphe normal">¶</button>

                <div class="tb-sep"></div>

                <!-- Listes -->
                <button type="button" class="tb-btn" @click="exec('insertUnorderedList')" title="Liste à puces">
                    <i class="fas fa-list-ul"></i>
                </button>
                <button type="button" class="tb-btn" @click="exec('insertOrderedList')" title="Liste numérotée">
                    <i class="fas fa-list-ol"></i>
                </button>

                <div class="tb-sep"></div>

                <!-- Alignement -->
                <button type="button" class="tb-btn" @click="exec('justifyLeft')" title="Aligner à gauche">
                    <i class="fas fa-align-left"></i>
                </button>
                <button type="button" class="tb-btn" @click="exec('justifyCenter')" title="Centrer">
                    <i class="fas fa-align-center"></i>
                </button>

                <div class="tb-sep"></div>

                <!-- Citation -->
                <button type="button" class="tb-btn" @click="setBlock('blockquote')" title="Citation">
                    <i class="fas fa-quote-left"></i>
                </button>
            </template>

            <div class="tb-sep"></div>
            <button type="button" class="tb-btn tb-erase" @click="exec('removeFormat'); setBlock('p')" title="Effacer le formatage">
                <i class="fas fa-eraser"></i>
            </button>
        </div>

        <div
            ref="editorRef"
            class="re-content"
            contenteditable="true"
            :data-placeholder="placeholder"
            :style="{ minHeight: (rows * 28) + 'px' }"
            @input="onInput"
            @focus="isFocused = true; isEditing = true; updateState();"
            @blur="isFocused = false; isEditing = false;"
            @keyup="updateState"
            @mouseup="updateState"
            @keydown.ctrl.b.prevent="exec('bold')"
            @keydown.ctrl.i.prevent="exec('italic')"
            @keydown.ctrl.u.prevent="exec('underline')"
        ></div>
    </div>
</template>

<style scoped>
.rich-editor {
    border: 1.5px solid #dfe8db;
    border-radius: 6px;
    overflow: hidden;
    transition: border-color 0.18s, box-shadow 0.18s;
    background: #fff;
}

.rich-editor.focused {
    border-color: #5cb85c;
    box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.14);
}

/* Toolbar */
.re-toolbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 2px;
    padding: 7px 10px;
    background: #f8faf7;
    border-bottom: 1px solid #e5ece2;
}

.tb-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 30px;
    border: 1px solid transparent;
    border-radius: 5px;
    background: transparent;
    color: #4a5e4c;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.12s;
    flex-shrink: 0;
}

.tb-btn:hover {
    background: #e8f5e8;
    border-color: #c3ddc0;
    color: #17351a;
}

.tb-btn.active {
    background: #5cb85c;
    border-color: #4a9e4a;
    color: #fff;
}

.tb-btn.tb-text {
    width: auto;
    padding: 0 8px;
    font-weight: 900;
    font-size: 0.78rem;
}

.tb-btn.tb-erase {
    color: #9aaa95;
}
.tb-btn.tb-erase:hover {
    color: #b42323;
    background: #fff5f5;
    border-color: #ffd4d4;
}

.tb-sep {
    width: 1px;
    height: 20px;
    background: #dfe8db;
    margin: 0 4px;
    flex-shrink: 0;
}

/* Zone éditable */
.re-content {
    padding: 12px 14px;
    color: #17351a;
    font-size: 0.95rem;
    line-height: 1.7;
    outline: none;
    word-break: break-word;
    white-space: pre-wrap;
}

.re-content:empty::before {
    content: attr(data-placeholder);
    color: #b0bcb2;
    font-style: italic;
    pointer-events: none;
}

/* Styles du contenu interne */
.re-content :deep(strong) { font-weight: 900; color: #17351a; }
.re-content :deep(em) { font-style: italic; }
.re-content :deep(u) { text-decoration: underline; }
.re-content :deep(s) { text-decoration: line-through; color: #68746a; }
.re-content :deep(h2) { font-size: 1.15rem; font-weight: 900; color: #17351a; margin: 10px 0 4px; }
.re-content :deep(h3) { font-size: 1rem; font-weight: 900; color: #17351a; margin: 8px 0 4px; }
.re-content :deep(p) { margin: 0 0 8px; }
.re-content :deep(ul), .re-content :deep(ol) { padding-left: 22px; margin: 6px 0; }
.re-content :deep(li) { margin: 3px 0; }
.re-content :deep(blockquote) {
    border-left: 3px solid #5cb85c;
    padding: 6px 14px;
    margin: 8px 0;
    color: #4a5e4c;
    font-style: italic;
    background: #f8faf7;
    border-radius: 0 4px 4px 0;
}
</style>
