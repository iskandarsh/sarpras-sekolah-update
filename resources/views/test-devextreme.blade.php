<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl">
            Demo DevExtreme
        </h2>
    </x-slot>

    <div class="p-8">

        <div id="gridContainer"></div>

    </div>

</x-app-layout>

<script>
    const data = [

        {
            id: 1,
            nama: "Laptop ASUS",
            kategori: "Elektronik",
            jumlah: 10,
            kondisi: "Baik"
        },

        {
            id: 2,
            nama: "Proyektor Epson",
            kategori: "Elektronik",
            jumlah: 3,
            kondisi: "Baik"
        },

        {
            id: 3,
            nama: "Speaker Portable",
            kategori: "Audio",
            jumlah: 5,
            kondisi: "Baik"
        },

        {
            id: 4,
            nama: "Papan Tulis Portable",
            kategori: "Furniture",
            jumlah: 2,
            kondisi: "Baik"
        }

    ];

    $(function() {

        $("#gridContainer").dxDataGrid({

            dataSource: data,

            keyExpr: "id",

            searchPanel: {
                visible: true
            },

            filterRow: {
                visible: true
            },

            headerFilter: {
                visible: true
            },

            groupPanel: {
                visible: true
            },

            paging: {
                pageSize: 5
            },

            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [5, 10, 20],
                showInfo: true
            },

            export: {
                enabled: true
            },

            columns: [

                {
                    dataField: "id",
                    caption: "ID"
                },

                {
                    dataField: "nama",
                    caption: "Nama Barang"
                },

                {
                    dataField: "kategori"
                },

                {
                    dataField: "jumlah"
                },

                {
                    dataField: "kondisi"
                }

            ]

        });

    });
</script>