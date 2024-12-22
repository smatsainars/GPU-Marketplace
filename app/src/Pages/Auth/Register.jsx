import { useState } from "react";

export default function Register() {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        password_conformation: '',
    });

    function handleRegister(e) {
        e.preventDefault();
        console.log(formData);
    }

    return (
        <>
            <h1 className="title">Register a new account</h1>

            <form onSubmit={handleRegister} className="w-1/2 mx-auto space-y-6">
                <div>
                    <input 
                        type="text" 
                        placeholder="Name" 
                        value={formData.name} 
                        onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    />
                </div>

                <div>
                    <input 
                        type="text" 
                        placeholder="Email" 
                        value={formData.email} 
                        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    />
                </div>

                <div>
                    <input 
                        type="password" 
                        placeholder="Password" 
                        value={formData.password} 
                        onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                    />
                </div>

                <div>
                    <input 
                        type="password" 
                        placeholder="Confirm Password" 
                        value={formData.password_conformation} 
                        onChange={(e) => setFormData({ ...formData, password_conformation: e.target.value })}
                    />
                </div>

                <button type="submit" className="primary-btn">Register</button>
            </form>
        </>
    );
}
