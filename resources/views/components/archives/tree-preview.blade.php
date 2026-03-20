{{-- resources/views/components/archives/tree-preview.blade.php --}}

<div
    x-init="init()"
    x-data="fileTree()"
    class="border rounded p-3"
    style="min-height:120px; max-height:400px; overflow:auto;"
>
    <template x-if="nodes.length === 0">
        <div class="text-muted">No files selected.</div>
    </template>

    <!-- ROOT -->
    <div x-ref="treeRoot"></div>
</div>
