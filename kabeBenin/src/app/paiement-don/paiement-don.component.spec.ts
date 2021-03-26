import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PaiementDonComponent } from './paiement-don.component';

describe('PaiementDonComponent', () => {
  let component: PaiementDonComponent;
  let fixture: ComponentFixture<PaiementDonComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PaiementDonComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PaiementDonComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
