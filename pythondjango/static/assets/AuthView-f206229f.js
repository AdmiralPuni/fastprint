import{_ as m,r as u,o as p,c as _,a as s,b as h,w as b,d as f,e as d,v as l,f as r,p as v,g}from"./index-05c69c0f.js";const w={data(){return{username:"",password:""}},methods:{submit(){console.log(this.username,this.password),this.$cookies.set("isAuth",!0,"1d"),this.$router.push("/dashboard")}}},e=i=>(v("data-v-a66b8981"),i=i(),g(),i),y={class:"d-flex justify-content-start align-items-center background",style:{height:"100vh"}},x=e(()=>s("div",{class:"flex-fill d-md-block d-none h-100"},[s("div",{class:"d-flex flex-column justify-content-center align-items-start p-5 h-100 gap-2"},[s("div",{class:"p-3 py-1 pt-0 fs-2 text-dark bg-warning"}," INTELLIGENCE UPDATE "),s("div",{class:"p-3 py-1 pt-0 fs-2 text-light w-75"}," Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s ")])],-1)),k={class:"col-12 col-md-3 h-100 bg-light shadow"},I={class:"d-flex flex-column justify-content-center align-items-center h-100"},V={class:"card shadow-sm w-100"},L={class:"card-body"},E={class:"d-flex justify-content-between align-items-center mb-3"},N=e(()=>s("div",{class:"fs-3"},[s("i",{class:"bi bi-grid"}),r(" Login ")],-1)),j=e(()=>s("i",{class:"bi bi-house"},null,-1)),A={class:"mb-2"},S=e(()=>s("label",{class:"form-label mb-1"},"Username",-1)),T={class:"mb-5"},U=e(()=>s("label",{class:"form-label mb-1"},"Password",-1)),B=e(()=>s("button",{type:"submit",class:"btn btn-primary w-100 mb-3"}," Login ",-1));function C(i,t,q,D,n,a){const c=u("router-link");return p(),_("div",y,[x,s("div",k,[s("div",I,[s("div",V,[s("div",L,[s("div",E,[N,h(c,{class:"btn btn-outline-dark",to:"/"},{default:b(()=>[j,r(" Home ")]),_:1})]),s("form",{action:"#",method:"post",onSubmit:t[2]||(t[2]=f((...o)=>a.submit&&a.submit(...o),["prevent"]))},[s("div",A,[S,d(s("input",{type:"text",class:"form-control fs-5","onUpdate:modelValue":t[0]||(t[0]=o=>n.username=o),required:""},null,512),[[l,n.username]])]),s("div",T,[U,d(s("input",{type:"password",class:"form-control fs-5","onUpdate:modelValue":t[1]||(t[1]=o=>n.password=o),required:""},null,512),[[l,n.password]])]),B],32)])])])])])}const P=m(w,[["render",C],["__scopeId","data-v-a66b8981"]]);export{P as default};