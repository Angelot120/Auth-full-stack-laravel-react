import React, { useState } from "react";
import Button from "./components/Button/Button";
import Input from "./components/input/Input";
import "./App.css";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";

export default function App() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();


  const handleSubmit = async(e) => {
    e.preventDefault();
    const fromData = new FormData();
    fromData.set("email", email);
    fromData.set("password", password);

    const response = await axios.post('http://127.0.0.1:8000/api/v1.0.0/login', fromData);

    try{

      if (response.data.success){
        toast.success(response.data.message)
        setTimeout(function(){
          navigate('/dashboard')
        }, 3500)
      }else{

        toast.error(response.data.message);
      }
    }catch(error){
      toast.error(response.data.message);
    }
  };

  return (
    <div>
      {/* <ToastContainer stacked/> */}
      <h1>Connexion</h1>
      <form onSubmit={handleSubmit}>
        <p>Renseigner vos informations de connexion pour vous connecter</p>
        <Input
          label={"Email"}
          reference={"email"}
          type={"email"}
          placeholder={"Saisir l'email ici..."}
          onChange={(e) => setEmail(e.target.value)}
          value={email}
        />

        <Input
          label={"Mot de passe"}
          reference={"password"}
          type={"password"}
          placeholder={"Saisir le mot de passe ici..."}
          onChange={(e) => setPassword(e.target.value)}
          value={password}
        />

        <div>
          <Button type={"submit"} text={"Soumettre"} />
          <br />
          <Button type={"reset"} text={"Annuler"} />
        </div>

        <div>
          <Link to={"/registration"}>Inscription</Link>
          {/* <a href={'/registration'}>Inscription</a> */}
        </div>
      </form>
    </div>
  );
}
