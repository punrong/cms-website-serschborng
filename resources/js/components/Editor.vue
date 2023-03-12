<template>
    <div>
        <ckeditor
            :editor="editor"
            v-model="editorData"
            :content="content"
            @input="onChange"
        ></ckeditor>
    </div>
</template>
<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from "@ckeditor/ckeditor5-vue";
import "ckeditor-tailwind-reset/ckeditor-tailwind-reset.css";

export default {
    components: {
        ckeditor: CKEditor.component,
    },
    props: {
        content: {
            type: String,
            default: () => "",
        },
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: this.content,
        };
    },
    methods: {
        onChange(data) {
            this.$emit("updateEditorData", data);
        },
    },
};
</script>
<style>
.ck-editor__editable_inline {
    min-height: 300px !important;
}
</style>