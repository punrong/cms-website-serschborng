import{_ as h,a as x,d as m,r as n,o as y,c as D,b as t,w as l,F as v,e as o,p as E,f as w}from"./app-2745b5b5.js";import{_ as I}from"./InputError-9c43904c.js";import{E as B}from"./Editor-f62a7311.js";const S={components:{InputError:I,Editor:B},data(){return{formData:{},statuses:{ACT:"ACTIVE",PND:"PENDING",DSBL:"DISABLED"},errorMsg:null}},props:{mentor:{type:Object,default:()=>({})},isTriggeredFromTable:{type:Boolean,default:!1}},methods:{initForm(){this.formData=this.mentor},onSubmit(){const e=new FormData;e.append("name",this.formData.name),e.append("email",this.formData.email),e.append("status",this.formData.status),e.append("phone_number",this.formData.phone_number),e.append("image",this.formData.image),e.append("description",this.formData.description),e.append("_method","PUT");const s={headers:{"content-type":"multipart/form-data"}};x.post(route("mentor.update",this.formData.id),e,s).then(r=>{r.data.success&&m.Inertia.visit(route("mentor.index"))}).catch(r=>{r.response.status===422&&(this.errorMsg=r.response.data.message),this.$toast.add({severity:"error",summary:"Error Message",detail:r.response.data.message,life:3e3})})},goBack(){this.isTriggeredFromTable?m.Inertia.visit(route("mentor.index")):m.Inertia.get(route("mentor.show",this.formData.id))},updateEditorData(e){this.formData.description=e}},created(){this.initForm()}},u=e=>(E("data-v-0b566d40"),e=e(),w(),e),M={class:"mx-auto flex container items-center justify-center mt-4"},k={class:"rounded w-full p-2 bg-white"},F={class:"px-4 bg-white shadow sm:rounded-lg"},T=u(()=>o("div",{class:"bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"},[o("header",null,[o("h2",{class:"text-lg font-medium text-gray-900"}," Mentor Information "),o("p",{class:"mt-1 text-sm text-gray-600"}," Update mentor's name, email, phone number, status, image and description ")])],-1)),N={class:"grid grid-cols-3 gap-x-4"},U={class:"pb-4 mb-1"},V=u(()=>o("span",{class:"block mb-1 font-bold text-base"},"Mentor's Background *",-1));function C(e,s,r,j,i,d){const c=n("Head"),a=n("FormKit"),b=n("Editor"),_=n("InputError"),g=n("Toast"),f=n("MenuSideBar");return y(),D(v,null,[t(c,{title:"Mentors"}),t(f,null,{default:l(()=>[o("div",M,[o("div",k,[t(a,{type:"button",label:"Go Back",onClick:s[0]||(s[0]=p=>d.goBack()),classes:{outer:"mb-2",input:"bg-blue-500 text-white font-bold px-3 mb-2 w-auto rounded-md py-2"}}),o("div",F,[T,t(a,{type:"form",modelValue:i.formData,"onUpdate:modelValue":s[1]||(s[1]=p=>i.formData=p),onSubmit:d.onSubmit,actions:!1,config:{classes:{label:"block mb-1 font-bold text-base",input:"w-full rounded-md py-2",help:"text-xs text-gray-500",message:"text-red-500 text-sm font-bold",messages:"pt-2"}}},{default:l(()=>[o("div",N,[t(a,{type:"text",label:"Name *",name:"name",validation:"required",classes:{outer:"pb-4",input:"border border-gray-400 px-2 mb-1"}}),t(a,{type:"email",label:"Email *",name:"email",validation:"required|email",classes:{outer:"pb-4",input:"border border-gray-400 px-2 mb-1"}}),t(a,{type:"tel",label:"Phone number",name:"phone_number",classes:{outer:"pb-4",input:"border border-gray-400 px-2 mb-1"}}),t(a,{type:"select",label:"Status *",options:i.statuses,name:"status",validation:"required",classes:{outer:"pb-4",input:"border border-gray-400 px-2 mb-1"}},null,8,["options"])]),t(a,{type:"image",label:"Image (2MB max)",name:"image",accept:".jpg,.png,.jpeg",classes:{outer:"pb-4",input:"border border-gray-400 px-2 mb-1"}}),o("div",U,[V,t(b,{content:i.formData.description,onUpdateEditorData:d.updateEditorData},null,8,["content","onUpdateEditorData"]),t(_,{class:"text-red-500 text-sm font-bold",message:i.errorMsg},null,8,["message"])]),t(a,{type:"submit",label:"Update",classes:{outer:"m-0 text-right",input:"$reset rounded-md py-2 bg-blue-500 text-white font-bold px-3 w-auto mb-2"}})]),_:1},8,["modelValue","onSubmit"])])])]),t(g)]),_:1})],64)}const G=h(S,[["render",C],["__scopeId","data-v-0b566d40"]]);export{G as default};