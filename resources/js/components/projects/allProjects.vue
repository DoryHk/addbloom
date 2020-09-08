<template>
    <div>
        <div class="row float-right">
            <pwa-install></pwa-install>
            <el-button
                class="el-col-push-1"
                @click="toggleModal"
            >
                Add New Project
            </el-button>
        </div>
        <div
            class="container row el-col-push-1"
            :key="renderCards">
            <div
                v-for="element in data"
                :key="element.id">
                <el-card class="box-card">
                    <div
                        slot="header"
                        class="clearfix">
                        <span>App Info</span>
                        <div class="float-right">
                            <el-button
                                circle
                                icon="el-icon-edit"
                                @click="editProject(element.id)">
                            </el-button>
                            <el-button
                                circle
                                icon="el-icon-delete"
                                :disabled="offline"
                                @click="deleteProject(element.id)">
                            </el-button>
                        </div>
                    </div>
                    <div class="image-size">
                        <img
                            v-if="element.logo.length"
                            class="image-style"
                            :src="`/images/${element.logo}`">
                        <span v-else>No logo available</span>
                        <a
                            v-if="element.logo.length"
                            :href="`/images/${element.logo}`"
                            download>
                            <el-icon
                                class="el-icon-download float-right">
                            </el-icon>
                        </a>
                    </div>
                    <div class="row">
                        <span
                            class="el-col-9">
                            Developer Name:
                        </span>
                        <div
                            class="el-col-12">
                            {{ element.developer_name }}
                        </div>
                    </div>
                    <div class="row">
                        <span
                            class="el-col-9 ">
                            App Name:
                        </span>
                        <div
                            class="el-col-12">
                            {{ element.app_name }}
                        </div>
                    </div>
                    <div class="row">
                        <span
                            class="el-col-9">
                            Version:
                        </span>
                        <div
                            class="el-col-15">
                            {{ element.version }}
                        </div>
                    </div>
                    <div class="row ml-about">
                        <span
                            class="el-col-offset-1 el-col-6">
                            About:
                        </span>
                        <div
                            class="el-col-17">
                            {{ element.about }}
                        </div>
                    </div>
                </el-card>
            </div>
        </div>
        <!--POP UP-->
        <el-dialog
            :title="title"
            :visible.sync="switchDialog"
            width="70%"
            center>
            <div class="container">
                <el-form
                    ref="form"
                    :model="form"
                    :rules="rules"
                    label-width="140px"
                    @submit.native.prevent>
                    <el-form-item
                        label="Developer Name"
                        prop="developer_name">
                        <el-input
                            required
                            v-model="form.developer_name">
                        </el-input>
                    </el-form-item>
                    <el-form-item
                        label="App name"
                        prop="app_name">
                        <el-input
                            required
                            v-model="form.app_name">
                        </el-input>
                    </el-form-item>
                    <el-form-item
                        label="Version Name"
                        prop="version">
                        <el-input
                            type="number"
                            required
                            v-model="form.version">
                        </el-input>
                    </el-form-item>
                    <el-form-item
                        label="About"
                        prop="about">
                        <el-input
                            type="textarea"
                            required
                            v-model="form.about">
                        </el-input>
                    </el-form-item>
                    <el-form-item label="Logo">
                        <div class="container">
                            <!--UPLOAD-->
                            <form enctype="multipart/form-data" novalidate>
                                <div
                                    v-if="file.length === 0" class="dropbox"
                                    @click="triggerInputFile">
                                    <input
                                        v-show="false"
                                        ref="inputFileMedia"
                                        type="file"
                                        multiple
                                        :accept="acceptedMimeTypes"
                                        @change="filesChanges"
                                    />
                                    <p>
                                        Browse
                                    </p>
                                </div>
                                <p v-if="invalidType">
                                    <span class="has-error">
                                        Invalid file type
                                    </span>
                                </p>
                            </form>
                            <!--SUCCESS-->
                            <div>
                                <img
                                    v-if="file.length !== 0"
                                    :src="file"
                                    class="img-responsive img-thumbnail"
                                />
                                <el-button
                                    v-if="file.length !== 0"
                                    class="delete-img-btn"
                                    plain
                                    icon="el-icon-delete"
                                    @click="remove"
                                ></el-button>
                            </div>
                        </div>
                    </el-form-item>
                </el-form>
            </div>
            <div slot="footer">
                <el-button
                    type="primary"
                    size="small"
                    :disabled="offline"
                    @click="onSubmit(form)">
                    {{ buttonTitle }}
                </el-button>
                <el-button
                    size="small"
                    @click="toggleModal">
                    Cancel
                </el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import _ from 'lodash';
import '@pwabuilder/pwainstall'

export default {
    name: 'allProjects',
    props: {
        offline: {
            require: false,
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            data: [],
            title: 'Add New Project',
            renderCards: 0,
            buttonTitle: 'Create',
            switchDialog: false,
            active: true,
            status: 'loading',
            acceptedMimeTypes: ['.tiff', '.jpeg', '.jpg', '.gif', '.png'],
            form: {
                app_name: '',
                developer_name: '',
                version: '',
                about: '',
                logo: '',
            },
            rules: {
                app_name: [
                    {
                        required: true,
                        message: 'Please input App name',
                        trigger: 'blur'
                    },
                    {
                        min: 3,
                        max: 254,
                        message: 'Length should be at least 3 characters',
                        trigger: 'blur'
                    }
                ],
                developer_name: [
                    {
                        required: true,
                        message: 'Please input Developer name',
                        trigger: 'blur'
                    },
                    {
                        min: 3,
                        max: 254,
                        message: 'Length should be at least 3 characters',
                        trigger: 'blur'
                    }
                ],
                version: [
                    {
                        required: true,
                        message: 'Please input Version',
                        trigger: 'blur'
                    }
                ],
                about: [
                    {
                        required: true,
                        message: 'Please input About',
                        trigger: 'blur'
                    }
                ]
            },
            invalidType: false,
            file: '',
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        toggleModal() {
            this.buttonTitle = 'Create';
            this.title = 'Add New Project';
            this.form = {
                app_name: '',
                developer_name: '',
                version: '',
                about: '',
                logo: '',
            };
            this.file = '';
            this.switchDialog = !this.switchDialog;
        },
        onSubmit(form) {
            this.$refs.form.validate((valid) => {
                if (valid) {
                    if (this.file.length === 0) {
                        this.form.logo = '';
                    }
                    if (this.buttonTitle === 'Create') {
                        this.createProject(form);
                    } else {
                        this.updateProject(form);
                    }
                    this.buttonTitle = 'Create';
                    this.title = 'Add New Project';
                    this.switchDialog = !this.switchDialog;
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        createProject(form) {
            axios.post('/api/projects/create', form)
                .then(response => {
                    this.data.push(response.data.data);
                    this.renderCards++;
                }).catch(error => {
                reject();
            });
        },
        updateProject(form) {
            axios.put(`/api/projects/${form.id}`, form)
                .then(response => {
                    let index = _.findIndex(this.data, {id: form.id});
                    this.data[index] = response.data.data;
                    this.renderCards++;
                }).catch(error => {
                reject();
            });
        },
        editProject(id) {
            this.toggleModal();
            this.buttonTitle = 'Update';
            this.title = 'Update Project';
            this.form = this.findProjectsById(id);
            this.file = this.form.logo.length ?
                `/images/${this.form.logo}`
                : '';
        },
        findProjectsById(id) {
            return _.find(this.data, {id: id});
        },
        deleteProject(id) {
            axios.delete(`/api/projects/${id}`)
                .then(response => {
                    _.remove(this.data, _.find(this.data, {id: id}));
                    this.renderCards++;
                }).catch(error => {
                reject();
            });
        },
        init() {
            this.status = "loading";
            this.fetchProjects()
                .then(() => (this.status = 'ready'))
                .catch(() => (this.status = 'error'))
        },
        fetchProjects() {
            return new Promise((resolve, reject) => {
                axios.get('/api/projects')
                    .then(response => {
                        this.resolveSuccessfulResponse(response);
                        resolve();
                    }).catch(error => {
                    this.resolveFailedResponse(error.response);
                    reject();
                });
            });
        },
        resolveSuccessfulResponse(response) {
            this.active = true;
            this.data = response.data;
        },
        resolveFailedResponse(response) {
            this.data = [];
        },
        filesChanges(event) {
            let file = event.target.files[0];
            let filter = file.name.split('.');
            if (this.acceptedMimeTypes.includes(`.${filter[1]}`)) {
                this.invalidType = false;
                this.file = URL.createObjectURL(file);
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.logo = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.invalidType = true;
            }
        },
        triggerInputFile() {
            this.$refs.inputFileMedia.click();
        },
        remove() {
            this.file = '';
        },
    }
}
</script>
<style>
pwa-install::part(openButton) {
    display: inline-block;
    line-height: 1;
    white-space: nowrap;
    cursor: pointer;
    background: #FFF;
    border: 1px solid #DCDFE6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    margin-right: 7px !important;
    box-sizing: border-box;
    outline: 0;
    margin: 0;
    transition: .1s;
    font-weight: 500;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
}

.ml-about {
    margin-left: -20px !important;
}

.float-right {
    float: right;
}

.image-style {
    max-height: 100%;
    border-radius: 20px;
}

.image-size {
    width: 120px;
    height: 60px;
    float: right;
}

.text {
    font-size: 14px;
}

.has-error {
    font-size: 14px;
    color: red;
}

.item {
    margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}

.clearfix:after {
    clear: both
}

.box-card {
    width: 480px;
    margin: 10px;
}

.img-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    max-width: 100%;
    height: auto;
}

.dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 10px 10px;
    max-width: 135px;
    min-height: 15px; /* minimum height */
    position: relative;
    cursor: pointer;
}

.dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
}

.dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
}

.delete-img-btn {
    display: block;
    margin: 0;
    border: 0;
    background-color: transparent;
    padding: 10px;
    float: right;
}
</style>
