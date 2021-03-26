import { TestBed } from '@angular/core/testing';

import { ProjetHumanitaireService } from './projet-humanitaire.service';

describe('ProjetHumanitaireService', () => {
  let service: ProjetHumanitaireService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProjetHumanitaireService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
