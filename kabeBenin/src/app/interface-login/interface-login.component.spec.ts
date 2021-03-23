import { ComponentFixture, TestBed } from '@angular/core/testing';

import { InterfaceLoginComponent } from './interface-login.component';

describe('InterfaceLoginComponent', () => {
  let component: InterfaceLoginComponent;
  let fixture: ComponentFixture<InterfaceLoginComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ InterfaceLoginComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(InterfaceLoginComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
