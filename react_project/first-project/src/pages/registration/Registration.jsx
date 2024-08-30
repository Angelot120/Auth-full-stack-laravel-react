import React, {useState} from 'react'
import {Link, useNavigate} from 'react-router-dom'
import Input from "../../components/input/Input";
import Button from "../../components/Button/Button";
import Alert from '../Alert/Alert';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

export default function Registration() {

  
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [passwordConfirm, setPasswordConfirm] = useState('')

  const [error, setError] = useState(false)
  const [errorText, setErrorText] = useState('')
  const navigate = useNavigate()

  const handleSubmit = (e) => {
    e.preventDefault()
    setError(false)
    if(email.trim().length < 6 || email.trim().length >= 32){
      setError(true)
      const errorMessage = 'L\'email doit comprendre entre 6 et 32 caractères !'
      // setErrorText(errorMessage)
      toast.error(errorMessage)
      return
    }
    if(password.trim().length < 6 || password.trim().length >= 32){
      setError(true)
      const errorMessage = 'Le mot de passe doit comprendre entre 6 et 32 caractères !'
      // setErrorText(errorMessage)
      toast.error(errorMessage)
      return
    }
    if(passwordConfirm.trim() !== password.trim()){
      setError(true)
      const errorMessage = 'Le deux mot de passe ne correspondent pas valide !'
      // setErrorText(errorMessage)
      toast.error(errorMessage)
      return
    }

    localStorage.setItem("email", email)
    navigate("/otp-code")
  }
  
  return (
    <div>
      <ToastContainer stacked/>
      <h1>Inscription</h1>
      <form onSubmit={handleSubmit}>
        <p>Rensigner le formulaire suivant pour vous inscrire</p>
        {error && <Alert text={errorText}/>}
      <Input 
        label={'Email'} 
        reference={'email'} 
        type={'text'} 
        placeholder={'Saisir l\'email ici...'} 
        onChange={(e) => setEmail(e.target.value)} 
        value={email}
      />

      <Input 
        label={'Mot de passe'} 
        reference={'password'} 
        type={'password'} 
        placeholder={'Saisir le mot de passe ici...'} 
        onChange={(e) => setPassword(e.target.value)} 
        value={password}
      />
      <Input 
        label={'Confirmation de mot de passe'} 
        reference={'passwordConfirm'} 
        type={'password'} 
        placeholder={'Saisir le mot de passe ici...'} 
        onChange={(e) => setPasswordConfirm(e.target.value)} 
        value={passwordConfirm}
      />
      <div>
        <Button type={'submit'} text={'Soumettre'}/><br/>
        <Button type={'reset'} text={'Annuler'}/>
      </div>
      </form>

      <Link to={'/'}>Connexion</Link>
    </div>
  )
}
