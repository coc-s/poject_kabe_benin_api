import { TestBed } from '@angular/core/testing';

import { BanqueAssociationService } from './banque-association.service';

describe('BanqueAssociationService', () => {
  let service: BanqueAssociationService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BanqueAssociationService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
