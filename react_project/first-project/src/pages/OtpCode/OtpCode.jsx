

import React, { useState } from 'react'
import Input from "../../components/input/Input";
import Button from "../../components/Button/Button";

export default function OtpCode() {

    const [otp, setOtp] = useState('')
  return (
    <div>
      
        <p>Un code a été envoyé dans votre boîte e-mail({localStorage.getItem('email')}). Veuillez saisir le code ici...</p>
        <form action="">
            <Input 
                label={'OTP Code'} 
                reference={'otp'} 
                type={'text'} 
                placeholder={'Saisir le code ici ...'} 
                onChange={(e) => setOtp(e.target.value)} 
                value={otp}
            />
            <Button text={'Soumettre'} type={'submit'}/>
      </form>
    </div>
  )
}
