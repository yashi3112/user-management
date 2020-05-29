import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { LoginService } from '../login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;

  constructor(
    private loginService: LoginService,
    private router: Router
  ) { }

  ngOnInit() {
    const username = localStorage.getItem('username') || '';
    this.loginForm = new FormGroup({
      username: new FormControl(username, [Validators.required, Validators.email]),
      password: new FormControl('', [Validators.required]),
      rememberMe: new FormControl(!!username)
    });
  }

  submit() {
    if (this.loginForm.invalid) { return; }
    const { rememberMe, username, password } = this.loginForm.value;
    this.handleRememberMe(rememberMe, username);
    // Todo: Call Login service and on success navigate to Dashboard.
    this.loginService.login(username, password)
      .subscribe(res => {
        // Todo: Handle success.
        this.router.navigateByUrl('/dashboard');
      });
  }

  handleRememberMe(rememberMe: boolean, username: string): void {
    if (rememberMe) {
      localStorage.setItem('username', username);
    } else {
      localStorage.removeItem('username');
    }
  }

}
