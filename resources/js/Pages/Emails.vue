<script setup>
import {
    DxDataGrid,
    DxColumn,
} from 'devextreme-vue/data-grid';
import {DxPopup} from 'devextreme-vue/popup';
import DxButton from 'devextreme-vue/button';
import CustomStore from 'devextreme/data/custom_store';
import {ref} from "vue";

const popupVisible = ref(false);
const cvs = ref([]);

const store = new CustomStore({
    load: async () => await axios.get('/api/getEmails')
})

const getAttachment = async _data => {
    const {data, error} = await axios.get(`/api/getAttachments/${_data.value}`);
    cvs.value = data
    popupVisible.value = true
}

</script>
<template>
    <DxDataGrid
        :data-source="store"
    >
        <DxColumn
            name="test"
            :width="100"
            data-field="mail_id"
            caption="Action"
            cell-template="cellTemplate"
        />
        <DxColumn data-field="date"/>
        <DxColumn data-field="from"/>
        <DxColumn data-field="subject"/>
        <DxColumn data-field="body"/>
        <DxColumn data-field="mail_id"/>
        <template #cellTemplate="{data}">
            <DxButton
                :width="120"
                text="Vue CV"
                type="success"
                styling-mode="text"
                @click="getAttachment(data)"
            />
        </template>
    </DxDataGrid>
    <DxPopup
        v-model:visible="popupVisible"
        :drag-enabled="false"
        :hide-on-outside-click="true"
        :show-close-button="true"
        :show-title="true"
        container=".dx-viewport"
        title="CV as Text"
    >
        <div>
            <template v-for="file in cvs">
                {{ file.attachment_content_text }}
            </template>
        </div>

    </DxPopup>
</template>
